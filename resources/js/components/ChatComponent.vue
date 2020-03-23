<template>
  <b-container fluid class="h-100">
      <b-row no-gutters class="h-100">
          <b-col cols="4">
              <b-form class="my-3 mx-2">
                <b-form-input class="text-center"
                    type="text"
                    v-model="querySearch" 
                    placeholder="Search contact..."
                ></b-form-input>
              </b-form>
              <contact-list-component 
                @conversationSelected="changeConversation($event)"
                :conversations="filteredConversations">
              </contact-list-component>
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
      userId: Number
    },
    data() {
      return {
        selectedConversation: null,
        myAvatar: '',
        messages: [],
        conversations: [],
        querySearch: ''
      };
    },
    mounted(){
      this.getConversations();

      //Channel for each user:
      Echo.private(`users.${this.userId}`)
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
        axios.get(`/api/profile/${this.selectedConversation.user_id}`).then((response) => {
          this.myAvatar = response.data.avatar;
        });
      },
      changeConversation(conversation){
        this.selectedConversation = conversation;
        this.getUser();
        this.getMessages();
      },
      getMessages(){
          axios.get(`/api/messages?contact_id=${this.selectedConversation.contact_id}`)
            .then((response) => {
              this.messages = response.data;
            });
      },
      addMessage(message){
        const conversation = this.conversations.find( (conversation) => {
          return conversation.contact_id == message.sender_id || conversation.contact_id == message.receiver_id;
        });

        const author = this.userId === message.sender_id ? 'You' : conversation.contact_name;
        
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