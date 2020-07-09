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

        <!--<div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroupFileAddon01">Avatar</span>
          </div>
          <div class="custom-file">
            <input type="file" class="custom-file-input" @change="selectFile" aria-describedby="inputGroupFileAddon01">
            <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
          </div>
        </div>
        <div class="custom-file">
          <input type="file" class="custom-file-input" id="files" ref="files" multiple :disabled="isBusy"
              v-on:change="handleFileUploads()">
          <label class="custom-file-label" for="customFile">Seleccione los anexos a enviar...</label>
          
        </div> -->
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
    data() {
      return {
        name: this.$store.state.user.name,
        email: this.$store.state.user.email,
        avatar: null,
        showDismissibleAlert: false,
      }
    },
    mounted(){
      
    },
    methods: {
      onImageChange(e){
        this.avatar = e.target.files[0];
      },
      onUpdate(){        
        const params = new FormData();
          params.append('name', this.name);
          params.append('avatar', this.avatar);
        
        // // Para verificar si el formData si tiene algo
        // for (var key of params.entries()) {
        //   console.log(key[0] + ': ' + key[1])
        // }
        axios.post(`/api/profile`, params)
          .then((response) => {
            console.log(response);
            if (response.data.success) {
              this.showDismissibleAlert = true;
              this.$store.commit('activeUser', response.data.profile);
            }
        })
        .catch(function (error) {
            console.log(error);
        });
      },
    },    
  }
</script>