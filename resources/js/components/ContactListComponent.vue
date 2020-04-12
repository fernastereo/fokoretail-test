<template>
  <b-list-group class="list-scroll">
    <contact-component 
      v-for="conversation in filteredConversations" 
      :key="conversation.id"
      :conversation="conversation"
      :selected="isSelected(conversation)"
      @click.native="selectConversation(conversation)">
    </contact-component>
  </b-list-group>
</template>
<style>
  .list-scroll {
    max-height: 280px;
    overflow-y: scroll;
    margin-bottom: 30px;
    overflow-x: hidden;
  }
</style>
<script>
  export default {
    methods: {
      selectConversation(conversation){
        this.$store.dispatch('getMessages', conversation);
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
      filteredConversations() {
        return this.$store.getters.filteredConversations;
      }
    }
  }
</script>