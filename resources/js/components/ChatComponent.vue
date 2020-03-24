<template>
  <b-container fluid class="h-100">
      <b-row no-gutters class="h-100">
          <b-col cols="4">
              <b-row>
                <b-col cols="4" md="4" class="text-center mx-0">
                  <b-button variant="link" class="p-0" v-b-modal.modal-profile v-b-tooltip.hover title="Profile">
                    <b-img rounded="circle" :src=myAvatar width="50" height="50" blank-color="#777" alt="img" class="m-1"></b-img>

                    <b-modal id="modal-profile" title="Invite a Friend">
                      <profile-component :user="user">
                      </profile-component>
                    </b-modal>
                  </b-button>
                  <b-button variant="link" class="p-0" v-b-modal.modal-group v-b-tooltip.hover title="Create a group">
                    <b-img rounded="circle" src="/storage/users/grupo.jpg" width="50" height="50" blank-color="#777" alt="img" class="m-1" style="border: 1px solid black;"></b-img>

                    <b-modal id="modal-group" title="Create a Chat Group">
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
                      <contact-list-component
                        @contactsSelected="getContacts($event)"
                        :conversations="filteredConversations">
                      </contact-list-component>
                      <div v-for="contact in contactsSelected" 
                        :key="contact.id">
                        <b-badge pill variant="primary">{{ contact.contact_name }}</b-badge> 
                      </div>
                    </b-modal>
                  </b-button>
                </b-col>
                <b-col class="pl-0">
                  <b-form class="my-3 mx-2">
                    <b-form-input class="text-center"
                        type="text"
                        v-model="querySearch" 
                        placeholder="Search contact..."
                    ></b-form-input>
                  </b-form>
                </b-col>
              </b-row>
              <contact-list-component class="h-50"
                @conversationSelected="changeConversation($event)"
                :conversations="filteredConversations">
              </contact-list-component>
              <hr>
              <invitations-component 
                :user-id="this.user.id"
                @conversationCreated="getConversations()">
              </invitations-component>
          </b-col>
          <b-col cols="8">
              <active-conversation-component
                v-if="selectedConversation"
                :contact-id="selectedConversation.contact_id"
                :contact-name="selectedConversation.contact_name"
                :contact-avatar="selectedConversation.contact_avatar"
                :my-avatar="myAvatar"
                :messages="messages"
                @messageCreated="addMessage($event)">
              </active-conversation-component>
          </b-col>
      </b-row>
  </b-container>
</template>

<script>
  export default {
    props: {
      user: Object
    },
    data() {
      return {
        selectedConversation: null,
        myAvatar: '',
        messages: [],
        conversations: [],
        querySearch: '',
        contactsSelected: [],
      };
    },
    mounted(){
      this.getUser();
      this.getConversations();
      
      //Channel for each user:
      Echo.private(`users.${this.user.id}`)
        .listen('MessageSent', (data) => {
            const message = data.message;
            message.written_by_me = false;
            this.addMessage(message);
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
      getUser(){
        axios.get(`/api/profile/${this.user.id}`).then((response) => {
          this.myAvatar = response.data.avatar;
        });
      },
      getContacts(contactSelected){
        console.log('Desde chat component', contactSelected);
        this.contactsSelected = contactSelected;
      },
      changeConversation(conversation){
        this.selectedConversation = conversation;
        
        this.getMessages();
      },
      getMessages(){
          axios.get(`/api/messages/${this.selectedConversation.contact_id}`)
            .then((response) => {
              this.messages = response.data;
            });
      },
      addMessage(message){
        const conversation = this.conversations.find( (conversation) => {
          return conversation.contact_id == message.sender_id || conversation.contact_id == message.receiver_id;
        });

        const author = this.user.id === message.sender_id ? 'You' : conversation.contact_name;
        
        conversation.last_message = `${author}: ${message.content}`;
        conversation.last_time = message.created_at;

        if(this.selectedConversation.contact_id == message.sender_id 
          || this.selectedConversation.contact_id == message.receiver_id){
            this.messages.push(message);
        }
      },
      getConversations(){
        axios.get('/api/conversations')
          .then((response) => {
            this.conversations = response.data;            
          }
        );
      },
      changeStatus(user, status){
        const index = this.conversations.findIndex((conversation) => {
          return conversation.contact_id == user.id;
        });
        if (index >= 0) {
          this.$set(this.conversations[index], 'online', status);          
        }
      }
    },
    computed: {
      filteredConversations(){
        return this.conversations.filter((conversation) => conversation.contact_name.toLowerCase().includes(this.querySearch.toLowerCase()));
      }
    }
  }
</script>