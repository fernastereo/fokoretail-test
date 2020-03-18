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
                :contact-avatar="selectedConversation.contact_avatar">
              </active-conversation-component>
          </b-col>
      </b-row>
  </b-container>
</template>

<script>
  export default {
    data() {
      return {
        selectedConversation: null,
      };
    },
    mounted(){
    },
    methods: {
      changeConversation(conversation){
        console.log('Conversacion seleccionada', conversation);
        this.selectedConversation = conversation;
      }
    }
  }
</script>