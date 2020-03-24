<template>
<b-container fluid class="h-100">
  <b-row no-gutters class="h-100">
    <b-col></b-col>
    <b-col cols="8">
      <b-alert variant="success" :show="showDismissibleAlert">Profile Updated</b-alert>
      <b-form enctype="multipart/form-data">
        <b-form-group label="Email address:">
          <b-form-input
            name="email"
            v-model="email"
            type="email"
            disabled
            placeholder="Enter email"
          ></b-form-input>
        </b-form-group>

        <b-form-group label="Your Name:">
          <b-form-input
            name="name"
            v-model="name"
            required
            placeholder="Enter name"
          ></b-form-input>
        </b-form-group>
        
        <b-form-group label="Profile Image">
          <b-form-file
            name="avatar"
            v-on:change="onImageChange"
            placeholder="Choose a file or drop it here..."
            drop-placeholder="Drop file here..."
          ></b-form-file>
        </b-form-group>

        <b-button variant="primary" @click="onUpdate">Submit</b-button>
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
        name: this.user.name,
        email: this.user.email,
        avatar: null,
        showDismissibleAlert: false,
      }
    },
    mounted(){
      
    },
    methods: {
      onImageChange(e){
        let files = e.target.files || e.dataTransfer.files;
        if (!files.length)
          return;
        this.createImage(files[0]);
      },
      createImage(file) {
        let reader = new FileReader();
        reader.onload = (e) => {
            this.avatar = e.target.result;
        };
        reader.readAsDataURL(file);
      },
      onUpdate(){        
        const params = {
            'name':this.name,
            'email':this.email,
            'avatar':this.avatar,
        };
        
        axios.put(`/api/profile/${this.user.id}`, params)
          .then((response) => {
            if (response.data.success) {
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