<template>
  <b-row no-gutters class="h-100">
    <b-col cols="8">
      <b-card no-body
        footer-bg-variant="light"
        footer-border-variant="dark"
        class="h-100"
        footer-class="p-1">
        <b-card-body class="card-body-scroll">
          <message-component 
            v-for="message in messages" 
            :key="message.id" 
            :written-by-me="message.written_by_me"
            :contactAvatar=selectedConversation.avatar
            :createdAt="message.created_at"
            :myAvatar=myAvatar>
              {{ message.content }}
          </message-component>
          <small class="mb-1 mr-1 font-italic"><b-badge pill variant="info">{{typing}}</b-badge></small>
        </b-card-body>
        <div slot="footer">
          <b-form class="m-0" @submit.prevent="postMessage" autocomplete="off">
            <b-input-group>
              <b-form-input class="p-0"
                type="text"
                v-model="newMessage"
                placeholder=" Type your message..."
              ></b-form-input>
              <b-input-group-append>
                <b-button type="submit" variant="primary">Send</b-button>
              </b-input-group-append>
            </b-input-group>
          </b-form>
        </div>
      </b-card>
    </b-col>

    <b-col cols="4" class="text-center">
      <b-img rounded="circle" :src="selectedConversation.avatar" width="120" height="120" blank-color="#777" alt="img" class="m-1"></b-img>
      <p>{{ selectedConversation.name }}</p>
      <hr>
      <b-form-checkbox
          id="checkbox-1"
          name="checkbox-1"
          value="accepted"
          unchecked-value="not_accepted"
          >
          Disabled notifications
      </b-form-checkbox>
    </b-col>
  </b-row>
</template>
<style>
  .card-body-scroll{
    max-height: calc(100vh - 120px);
    overflow-y: scroll;
  }
</style>
<script>
    export default {
      data(){
        return {
          newMessage: '',
          typing: ''
        }
      },
      mounted() {
        this.scrollToBottom();

        Echo.private(`users.${this.$store.state.user.id}`)
          .listen('MessageSent', (data) => {
            console.log('message sent channel: users.', this.$store.state.user.id)
            if (data.message.user_id != this.$store.state.user.id) {
              const message = data.message;
              message.written_by_me = false;
              this.$store.commit('addMessage', message);
            }
          });
        
        Echo.private('chat')
          .listenForWhisper('typing', (data) => {
            //if I'm talkin with whom is writing and who is writing is writing to me
            if (this.selectedConversation.users.includes(data.userFrom.id) && data.usersTo.includes(this.$store.state.user.id)) {
              if(data.currentMessage != ''){
                this.typing = `${data.userFrom.name} is Typing...`;
              }else{
                this.typing = '';
              };
            } else {
              this.typing = '';
            }
          });
      },
      methods: {
        postMessage(){
          this.$store.dispatch('postMessage', this.newMessage);
          this.newMessage = '';
        },
        scrollToBottom(){
          const el = document.querySelector('.card-body-scroll');
          el.scrollTop = el.scrollHeight;
        }
      },
      computed:{
        myAvatar() {
          return this.$store.state.user.avatar;
        },
        selectedConversation(){
          return this.$store.state.selectedConversation;
        },
        messages() {
          return this.$store.state.messages;
        }
      },
      updated() {
        //for watching messages variable, everytime it changes we're gonna call scrollToBottom
        this.scrollToBottom();
      },
      watch: {
        newMessage(){
          console.log(this.selectedConversation.users);
          Echo.private('chat')
            .whisper('typing', {
              userFrom: this.$store.state.user,
              usersTo: this.selectedConversation.users,
              currentMessage: this.newMessage,
            });
        }
      }
    }
</script>