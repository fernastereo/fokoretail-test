<template>
  <b-row no-gutters class="h-100">
    <b-col cols="8">
      <b-card no-body
        footer-bg-variant="light"
        footer-border-variant="dark"
        title="Active Conversation"
        class="h-100"
        footer-class="p-1">
        <b-card-body class="card-body-scroll">
          <message-component 
            v-for="message in messages" 
            :key="message.id" 
            :written-by-me="message.written_by_me">
              {{ message.content }}
          </message-component>
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
      <b-img rounded="circle" :src=contactAvatar width="120" height="120" blank-color="#777" alt="img" class="m-1"></b-img>
      <p>{{ contactName }}</p>
      <hr>
      <b-form-checkbox
          id="checkbox-1"
          name="checkbox-1"
          value="accepted"
          unchecked-value="not_accepted"
          >
          Desabled notifications
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
      props: {
        contactId: Number,
        contactName: String,
        contactAvatar: String,
        messages: Array,
      },
      data(){
        return {
          newMessage: ''
        }
      },
      mounted() {

      },
      methods: {
        postMessage(){
          const params = {
            'receiver_id': this.contactId,
            'content': this.newMessage
          };
          axios.post('/api/messages', params)
          .then((response) => {
            if(response.data.success){
              this.newMessage = '';
              const message = response.data.message;
              message.written_by_me = true;
              this.$emit('messageCreated', message);
            }
          });
        },
        scrollToBottom(){
          const el = document.querySelector('.card-body-scroll');
          el.scrollTop = el.scrollHeight;
        }
      },
      updated() {
        //for watching messages variable, everytime it changes we're gonna call scrollToBottom
        this.scrollToBottom();
      }
    }
</script>