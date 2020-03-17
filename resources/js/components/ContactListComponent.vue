<template>
  <div>
    <b-form class="my-3 mx-2">
        <b-form-input class="text-center"
            type="text"
            placeholder="Search contact..."
        ></b-form-input>
    </b-form>
    <b-list-group>
        <contact-component variant="dark"></contact-component>
        <contact-component variant=""></contact-component>
        <contact-component variant=""></contact-component>
        <contact-component variant=""></contact-component>
        <contact-component variant=""></contact-component>
    </b-list-group>
  </div>
</template>

<script>
    export default {
      data(){
        return {
        }
      },
      mounted() {
          console.log('ContactListComponent mounted.')
      }
    }
</script>