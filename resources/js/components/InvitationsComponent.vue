<template>
  <div class="table-scroll">
    <b-table striped hover :items="invitations" :fields="fields" small caption-top class="mb-0">
      
      <template v-slot:table-caption>
        <b-row>
          <b-col cols="7">
            <p>Received Invitations <b-badge variant="warning">{{ invitations.length }} New</b-badge></p>
          </b-col>
          <b-col>
            <div>
              <b-button size="sm" variant="primary" v-b-modal.modal-1>Invite a Friend</b-button>

              <b-modal id="modal-1" title="Invite a Friend">
                <invitation-form-component 
                  @invitationCreated="getInvitations()">
                </invitation-form-component>
              </b-modal>
            </div>
          </b-col>
        </b-row>
      </template>

        
      
      <template v-slot:cell(actions)="row">
        <b-button size="sm" variant="primary" @click="accept(row.item, row.index, $event.target)" class="mr-1">
          Accept
        </b-button>
        <b-button size="sm" variant="danger" @click="deny(row.item, row.index, $event.target)" class="mr-1">
          Deny
        </b-button>
      </template>
    </b-table>
    <b-modal :id="infoModal.id" :title="infoModal.title" ok-only @hide="resetInfoModal">
      <pre>{{ infoModal.content }}</pre>
    </b-modal>
  </div>
</template>
<style>
  .table-scroll{
    max-height: 200px;
    overflow-y: scroll;
    overflow-x: hidden;
  }
</style>
<script>
  export default {
    props:{
      userId: Number
    },
    data() {
      return {
        fields: ['user_name', 'actions'],
        invitations: [],
        infoModal: {
          id: 'info-modal',
          title: '',
          content: ''
        }
      }
    },
    mounted() {
      this.getInvitations();
    },
    methods: {
      getInvitations(){
        axios.get(`/api/invitations/${this.userId}`)
            .then((response) => {
              this.invitations = response.data;
            });
      },
      accept(item, index, button) {
        const params = {
            'invitation_id': item.id,
            'user_id': item.user_id,
            'contact_id': item.contact_id,
        };
        axios.post('/api/conversations', params)
          .then((response) => {
            if (response.data.success) {
              this.invitations.splice(index, 1);
              this.$emit('conversationCreated');
            }
        })
        .catch(function (error) {
            console.log(error);
        });
        this.infoModal.title = `Invitation Accepted`
        this.infoModal.content = `You have a new conversation with ${item.user_name}`
        this.$root.$emit('bv::show::modal', this.infoModal.id, button)
      },
      deny(item, index, button) {
        axios.put(`/api/invitations/${item.id}/deny`)
          .then((response) => {
            if (response.data.success) {
              this.invitations.splice(index, 1);
            }
          })
        .catch(function (error) {
            console.log(error);
        });
        this.infoModal.title = `Invitation Denied`
        this.infoModal.content = `The invitation from ${item.user_name} was denied.`
        this.$root.$emit('bv::show::modal', this.infoModal.id, button)
      },
      resetInfoModal() {
        this.infoModal.title = ''
        this.infoModal.content = ''
      },
    }
  }
</script>