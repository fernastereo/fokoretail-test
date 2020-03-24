<template>
  <div class="table-scroll">
    <b-table striped hover :items="invitations" :fields="fields" small caption-top class="mb-0">
      <template v-slot:table-caption>Invitations <b-badge variant="warning">3 New</b-badge></template>
      <template v-slot:cell(actions)="row">
        <b-button size="sm" variant="primary" @click="accept(row.item, row.index, $event.target)" class="mr-1">
          Accept
        </b-button>
        <b-button size="sm" variant="danger" @click="deny(row.item, row.index, $event.target)" class="mr-1">
          Deny
        </b-button>
      </template>
      <template v-slot:row-details="row">
        <b-card>
          <ul>
            <li v-for="(value, key) in row.item" :key="key">{{ key }}: {{ value }}</li>
          </ul>
        </b-card>
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
  }
</style>
<script>
  export default {
    props:{
      userId: Number
    },
    data() {
      return {
        // Note `isActive` is left out and will not appear in the rendered table
        fields: ['user_name', 'actions'],
        invitations: [],
        items: [
          { user_id: 23, from: 'Dickerson' },
          { user_id: 21, from: 'Larsen' },
          { user_id: 89, from: 'Geneva' },
          { user_id: 38, from: 'Jami' }
        ],
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
              console.log(response.data);
              this.invitations = response.data;
            });
      },
      accept(item, index, button) {
        this.infoModal.title = `Accept Row index: ${index}`
        this.infoModal.content = JSON.stringify(item, null, 2)
        this.$root.$emit('bv::show::modal', this.infoModal.id, button)
      },
      deny(item, index, button) {
        this.infoModal.title = `Deny Row index: ${index}`
        this.infoModal.content = JSON.stringify(item, null, 2)
        this.$root.$emit('bv::show::modal', this.infoModal.id, button)
      },
      resetInfoModal() {
        this.infoModal.title = ''
        this.infoModal.content = ''
      },
    }
  }
</script>