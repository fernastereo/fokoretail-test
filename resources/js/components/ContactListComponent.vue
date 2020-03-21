<template>
  <div>
    <b-form class="my-3 mx-2">
        <b-form-input class="text-center"
            type="text"
            placeholder="Search contact..."
        ></b-form-input>
    </b-form>
    <b-list-group>
        <contact-component 
          v-for="conversation in conversations" 
          :key="conversation.id"
          :conversation="conversation"
          @click.native="selectConversation(conversation)">
        </contact-component>
    </b-list-group>
  </div>
</template>

<script>
    export default {
      props:{
        conversations: Array,
      },
      data(){
        return {
        }
      },
      mounted() {
          console.log('ContactListComponent mounted.')
      },
      methods: {
        selectConversation(conversation){
          this.$emit('conversationSelected', conversation);
        }
      }
    }
</script>