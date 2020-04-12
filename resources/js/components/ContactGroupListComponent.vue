<template>
  <b-list-group class="list-scroll">
    <contact-component 
      v-for="conversation in filteredConversationsForGroups" 
      :key="conversation.id"
      :conversation="conversation"
      :selected="isSelected(conversation)"
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
      data(){
        return {
          contacts: [],
        }
      },
      methods: {
        selectConversation(conversation){
          if (this.contacts.length <= 9) {
            if (!this.contacts.includes(conversation)) {
              this.contacts.push(conversation);          
            }
          }
          this.$store.commit('addContactsToGroup', this.contacts);
        },
        isSelected(conversation) {
          if(this.selectedConversation){
            return this.selectedConversation.id === conversation.id;
          }
          return false;
        }
      },
      computed: {
        selectedConversation() {
          return this.$store.state.selectedConversation;
        },
        filteredConversationsForGroups() {
          return this.$store.getters.filteredConversationsForGroups;
        }
      }
    }
</script>