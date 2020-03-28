<template>
  <b-list-group class="list-scroll">
    <contact-component 
      v-for="conversation in conversations" 
      :key="conversation.id"
      :conversation="conversation"
      :selected="selectedConversationId === conversation.id"
      @click.native="selectConversation(conversation)">
    </contact-component>
  </b-list-group>
</template>
<style>
  .list-scroll{
    max-height: 280px;
    overflow-y: scroll;
    margin-bottom: 30px;
    overflow-x: hidden;
  }
</style>
<script>
    export default {
      props:{
        conversations: Array,
      },
      data(){
        return {
          selectedConversationId: null,
          contacts: [],
        }
      },
      mounted() {

      },
      methods: {
        selectConversation(conversation){
          if (this.contacts.length <= 9) {
            if (!this.contacts.includes(conversation)) {
              this.contacts.push(conversation);          
            }
          }
          this.$emit('contactsSelected', this.contacts);
          this.selectedConversationId = conversation.id;
          this.$emit('conversationSelected', conversation);
        }
      }
    }
</script>