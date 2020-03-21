<template>
  <b-container fluid class="h-100">
      <b-row no-gutters class="h-100">
          <b-col cols="4">
              <contact-list-component 
                @conversationSelected="changeConversation($event)"
                :conversations="conversations">
              </contact-list-component>
          </b-col>
          <b-col cols="8">
              <active-conversation-component
                v-if="selectedConversation"
                :contact-id="selectedConversation.contact_id"
                :contact-name="selectedConversation.contact_name"
                :contact-avatar="selectedConversation.contact_avatar"
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
        messages: [],
        conversations: [],
      };
    },
    mounted(){
      this.getConversations();

      Echo.channel(`users.${this.userId}`)
        .listen('MessageSent', (data) => {
            console.log(message);

            const message = data.message;
            message.written_by_me = false;
            this.addMessage(message);
        });
    },
    methods: {
      changeConversation(conversation){
        this.selectedConversation = conversation;
        this.getMessages();
      },
      getMessages(){
          axios.get(`/api/messages?contact_id=${this.selectedConversation.contact_id}`).then((response) => {
          console.log(response.data);
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
    }
  }
</script>