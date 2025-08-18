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

        <b-form-group label="Your Fullname:">
          <b-form-input
            name="name"
            v-model="name"
            required
            placeholder="Enter fullname"
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
          <div class="text-center mb-3">
            <b-img
              :src="displayedImage"
              fluid
              :alt="previewImage ? 'New Avatar Preview' : 'Current Avatar'"
              class="avatar-preview"
            ></b-img>
          </div>

          <b-form-file
            name="avatar"
            v-on:change="onImageChange"
            placeholder="Choose a file or drop it here..."
            drop-placeholder="Drop file here..."
            accept="image/*"
          ></b-form-file>
        </b-form-group>
        <b-button variant="primary" @click="onUpdate" class="mt-3">Submit</b-button>
      </b-form>
    </b-col>
    <b-col></b-col>
  </b-row>
</b-container>
</template>

<script>
  export default {
    props: {
      user: Object
    },
    data() {
      return {
        avatar: null,
        previewImage: null,
        showDismissibleAlert: false,
      }
    },
    computed: {
      name: {
        get() {
          return this.$store.state.user.name
        },
        set(value) {
          this.$store.commit('activeUser', { ...this.$store.state.user, name: value })
        }
      },
      email: {
        get() {
          return this.$store.state.user.email
        },
        set(value) {
          this.$store.commit('activeUser', { ...this.$store.state.user, email: value })
        }
      },
      displayedImage() {
        // Si hay una vista previa de un nuevo archivo, mostrar esa
        // Si no, mostrar el avatar actual del usuario
        return this.previewImage || this.$store.state.user.avatar || this.$store.state.defaultImagePath + 'default.png';
      }
    },
    beforeMount(){
      if (this.user) {
        this.$store.commit('activeUser', this.user);
      }
    },
    mounted(){
      console.log('store', this.$store.state)
    },
    methods: {
      onImageChange(e){
        const file = e.target.files[0];
        this.avatar = file;

        if (file) {
          this.previewImage = URL.createObjectURL(file);
        } else {
          this.previewImage = null;
        }
      },
      onUpdate(){
        const params = new FormData();
        params.append('name', this.name);

        // Solo agregar el avatar si se ha seleccionado un archivo
        if (this.avatar) {
          params.append('avatar', this.avatar);
        }

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

<style scoped>
.avatar-preview {
  width: 200px;
  height: 200px;
  object-fit: cover;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
  margin: 0 auto;
}
</style>
