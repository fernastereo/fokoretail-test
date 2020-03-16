<template>
  <b-row>
    <b-col cols="8"></b-col>
    <b-col cols="4">
      <b-img rounded="circle" blank width="50" height="50" blank-color="#777" alt="img" class="m-1"></b-img>
      <p>Usuario Seleccionado</p>
      <hr>
      <b-form-checkbox
          id="checkbox-1"
          v-model="status"
          name="checkbox-1"
          value="accepted"
          unchecked-value="not_accepted"
          >
          I accept the terms and use
      </b-form-checkbox>
    </b-col>
  </b-row>
</template>

<script>
    export default {
      data(){
        return {
        }
      },
      mounted() {
          console.log('Component mounted.')
      }
    }
</script>