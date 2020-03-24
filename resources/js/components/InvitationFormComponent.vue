<template>
<b-container fluid class="h-100">
  <b-row no-gutters class="h-100">
    <b-col></b-col>
    <b-col cols="8">
      <b-alert variant="success" :show="showDismissibleAlert">Invitation sent</b-alert>
      <b-form>
        <b-form-group label="Your friend's Email address:">
          <b-form-input
            name="email"
            type="email"
            v-model="email"
            placeholder="Enter email"
          ></b-form-input>
        </b-form-group>
        <b-button variant="primary" @click="onSend">Invite!</b-button>
      </b-form>
    </b-col>
    <b-col></b-col>
  </b-row>
</b-container>
</template>

<script>
  export default {
    props: {
      user: Object,
    },
    data() {
      return {
        email: '',
        showDismissibleAlert: false,
      }
    },
    methods: {
      onSend(){        
        const params = {
            'email':this.email,
        };
        
        axios.post('/api/invite/', params)
          .then((response) => {
            if (response.data.success) {
              console.log(response.data.success);
              this.showDismissibleAlert = true;
            }
        })
        .catch(function (error) {
            console.log(error);
        });
      },
    },    
  }
</script>