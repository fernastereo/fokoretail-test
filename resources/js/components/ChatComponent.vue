<template>
  <b-container fluid class="h-100">
      <b-row no-gutters class="h-100">
          <b-col cols="4">
              <contact-list-component 
                @conversationSelected="changeConversation($event)">
              </contact-list-component>
          </b-col>
          <b-col cols="8">
              <active-conversation-component
                v-if="selectedConversation"
                :contact-id="selectedConversation.contact_id"
                :contact-name="selectedConversation.contact_name"
                :contact-avatar="selectedConversation.contact_avatar"
                :messages="messages">
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
        messages: []
      };
    },
    mounted(){
      Echo.channel('fokochat')
        .listen('MessageSent', (data) => {
            const message = data.message;
            message.written_by_me = (this.userId == message.from_id);
            this.messages.push(message);
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
    }
  }
</script>