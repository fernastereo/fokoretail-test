<template>
<b-container fluid class="h-100">
  <b-row no-gutters class="h-100">
    <b-col></b-col>
    <b-col cols="8">
      <b-alert :variant="alert" :show="showDismissibleAlert">{{ alertmsg }}</b-alert>
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
    data() {
      return {
        email: '',
        showDismissibleAlert: false,
        alert: 'success',
        alertmsg: ''
      }
    },
    methods: {
      onSend(){        
        const params = {
            'email':this.email,
        };
        
        axios.post('/messenger/api/invite/', params)
          .then((response) => {
            if (response.data.success) {
              this.showDismissibleAlert = true;
              this.alertmsg = response.data.successmsg;
              this.alert = "success";
            }else{
              if (response.data.error) {
                this.showDismissibleAlert = true;
                this.alertmsg = response.data.error;
                this.alert = "danger";
              }
            }
        })
        .catch(function (error) {
            console.log(error);
        });
      },
    },    
  }
</script>