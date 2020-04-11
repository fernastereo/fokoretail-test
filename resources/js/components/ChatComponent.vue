<template>
  <b-container fluid class="h-100">
      <b-row no-gutters class="h-100">
          <b-col cols="4">
              <b-row>
                <b-col cols="4" md="4" class="text-center mx-0">
                  <b-button variant="link" class="p-0" v-b-modal.modal-profile v-b-tooltip.hover title="Profile">
                    <b-img rounded="circle" :src=myAvatar width="50" height="50" blank-color="#777" alt="img" class="m-1"></b-img>

                    <b-modal id="modal-profile" title="My Profile Settings" hide-footer>
                      <profile-component 
                        :user="user">
                      </profile-component>
                    </b-modal>
                  </b-button>
                  <b-button variant="link" class="p-0" v-b-modal.modal-group v-b-tooltip.hover title="Create a group">
                    <b-img rounded="circle" src="/storage/users/grupo.JPG" width="50" height="50" blank-color="#777" alt="img" class="m-1"></b-img>

                    <b-modal id="modal-group" title="Create a Chat Group" ok-only ok-variant="sm">
                      <div slot="modal-title">
                        Create a Chat Group <b-badge pill variant="primary">{{ contactsSelected.length }}</b-badge>
                      </div>
                      <b-form>
                        <b-form-group label="Group:">
                          <b-form-input
                            name="name"
                            v-model="name"
                            required
                            placeholder="Enter name"
                          ></b-form-input>
                        </b-form-group>
                      </b-form>
                      <!-- <contact-list-component
                        @contactsSelected="getContacts($event)"
                        :conversations="filteredConversationsForGroups">
                      </contact-list-component>
                      <div v-for="contact in contactsSelected" 
                        :key="contact.id" class="contacts-selected">
                        <b-badge pill variant="primary">{{ contact.name }}</b-badge>
                      </div> -->
                      <div slot="modal-ok">
                        <b-button variant="primary" @click="onCreateGroup">Submit</b-button>
                      </div>
                    </b-modal>
                  </b-button>
                </b-col>
                <b-col class="pl-0">
                  <contact-form-component></contact-form-component>
                </b-col>
              </b-row>
              <contact-list-component class="h-50" />
              <hr>
              <invitations-component 
                :user-id="this.user.id"
                @conversationCreated="getConversations()">
              </invitations-component>
          </b-col>
          <b-col cols="8">
              <active-conversation-component
                v-if="selectedConversation"
                :my-avatar="myAvatar"
                @messageCreated="addMessage($event)">
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
        myAvatar: this.user.avatar,
        contactsSelected: [],
        contact: [],
        name: ''
      };
    },
    mounted(){
      // this.$store.commit('activeUser', this.user);
      this.$store.dispatch('getConversations', this.user);
      
      //Channel for each user:
      Echo.private(`users.${this.user.id}`)
        .listen('MessageSent', (data) => {
          if (data.message.user_id != this.user.id) {
            const message = data.message;
            message.written_by_me = false;
            this.addMessage(message);
          }
        });
      //Channel for get the presence of all users
      Echo.join('messenger')
        .here((users) => {
          users.forEach((user) => this.changeStatus(user, true));
        })
        .joining((user) => {
          this.changeStatus(user, true);
        })
        .leaving((user) => {
          this.changeStatus(user, false);
        });
    },
    methods: {
      getUser(id){
        axios.get(`/api/profile/${id}`).then((response) => {
          this.contact = response.data;
        });
      },
      getContacts(contactSelected){
          this.contactsSelected = contactSelected;        
      },
      addMessage(message){
        const conversation = this.$store.state.conversations.find( (conversation) => {
          return conversation.id == message.conversation_id; 
        });

        const author = this.user.id === message.user_id ? 'You' : conversation.name;
        
        conversation.last_message = `${author}: ${message.content}`;
        conversation.last_time = message.created_at;

        if(this.selectedConversation.id == message.conversation_id) {
            this.$store.commit('addMessage', message);
        }
      },
      changeStatus(user, status){
        const index = this.$store.state.conversations.findIndex((conversation) => {
          return conversation.users.includes(user.id);
        });
        if (index >= 0) {
          this.$set(this.$store.state.conversations[index], 'online', status);          
        }
      },
      onCreateGroup(){
        const users = [];
        this.contactsSelected
          .map((elem) => elem.users[0])
          .forEach((elem) => users.push({id: elem}));
        users.push({id: this.user.id});

        const params = {
            'name': this.name,
            'users': users,
        };

        axios.post('/api/conversations', params)
          .then((response) => {
            if (response.data.success) {
              this.getConversations();
            }
        })
        .catch(function (error) {
            console.log(error);
        });
      }
    },
    computed: {
      selectedConversation() {
        return  this.$store.state.selectedConversation;
      },
    }
  }
</script>