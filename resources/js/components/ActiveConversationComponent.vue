<template>
  <b-row no-gutters class="h-100">
    <b-col cols="8">
      <div class="card h-100">
        <div class="card-header text-center">
          Active Conversation
        </div>
        <div class="card-body h-100">
          <message-component 
            v-for="message in messages" 
            :key="message.id" 
            :written-by-me="message.written_by_me">
              {{ message.content }}
          </message-component>
        </div>
        <div class="card-footer p-2">
          <b-form class="mb-0" @submit.prevent="postMessage" autocomplete="off">
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
      </div>
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
            }
          });
        }
      }
    }
</script>