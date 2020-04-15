<template>
  <b-container fluid class="h-100">
      <b-row no-gutters class="h-100">
          <b-col cols="4">
              <b-row>
                <b-col cols="4" md="4" class="text-center mx-0">
                  
                  <b-button variant="link" class="p-0" v-b-modal.modal-profile v-b-tooltip.hover title="Profile">
                    <b-img rounded="circle" :src="myAvatar" width="50" height="50" blank-color="#777" alt="img" class="m-1"></b-img>
                    <b-modal id="modal-profile" title="My Profile Settings" hide-footer>
                      <profile-component></profile-component>
                    </b-modal>
                  </b-button>
                  
                  <b-button variant="link" class="p-0" v-b-modal.modal-group v-b-tooltip.hover title="Create a group">
                    <b-img rounded="circle" src="/storage/users/grupo.JPG" width="50" height="50" blank-color="#777" alt="img" class="m-1"></b-img>
                    <create-group-component></create-group-component>
                  </b-button>
                  
                </b-col>
                <b-col class="pl-0">
                  <contact-form-component></contact-form-component>
                </b-col>
              </b-row>
              <contact-list-component class="h-50" />
              <hr>
              <invitations-component></invitations-component>
          </b-col>
          <b-col cols="8">
              <active-conversation-component
                v-if="selectedConversation">
              </active-conversation-component>
          </b-col>
      </b-row>
  </b-container>
</template>
<style>
  .contacts-selected{
    display: inline;
  }
</style>
<script>
  export default {
    props: {
      user: Object
    },
    data() {
      return {
        contact: [],
      };
    },
    beforeMount(){
      this.$store.commit('activeUser', this.user);
    },
    mounted(){
      this.$store.dispatch('getConversations', this.user);
      
      Echo.private(`users.${this.$store.state.user.id}`)
        .listen('InvitationSent', (data) => {
          console.log('invitacion recibida de ', data.invitation.user_id);
          if (data.invitation.contact_id == this.$store.state.user.id) {
            this.$store.dispatch('getInvitations', this.$store.state.user);
          }
        });

      //Channel for get the presence of all users
      Echo.join('messenger')
        .here((users) => {
          users.forEach((user) => this.changeStatus(user, true));
          // console.log(users);
        })
        .joining((user) => {
          this.$toaster.success(`${user.name} has joined the room`);
          this.changeStatus(user, true);
        })
        .leaving((user) => {
          this.$toaster.error(`${user.name} has left the room`);
          this.changeStatus(user, false);
        });
    },
    methods: {
      getUser(id){
        axios.get(`/api/profile/${id}`).then((response) => {
          this.contact = response.data;
        });
      },
      changeStatus(user, status){
        const index = this.$store.state.conversations.findIndex((conversation) => {
          return conversation.users.includes(user.id);
        });
        if (index >= 0) {
          this.$set(this.$store.state.conversations[index], 'online', status);          
        }
      },
    },
    computed: {
      myAvatar() {
        return this.$store.state.user.avatar;
      },
      selectedConversation() {
        return  this.$store.state.selectedConversation;
      },
    }
  }
</script>