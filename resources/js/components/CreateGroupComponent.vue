<template>
  <b-modal id="modal-group" title="Create a Chat Group" ok-only ok-variant="sm">
    <div slot="modal-title">
      Create a Chat Group <b-badge pill variant="primary">{{ this.$store.state.contactsSelected.length }}</b-badge>
    </div>
    <b-form>
      <b-form-group label="Group:">
        <b-form-input
          name="name"
          v-model="name"
          required
          placeholder="Enter name"
        ></b-form-input>
      </b-form-group>
    </b-form>
    <contact-group-list-component>
    </contact-group-list-component>
    <div v-for="contact in this.$store.state.contactsSelected" 
      :key="contact.id" class="contacts-selected">
      <b-badge pill variant="primary">{{ contact.name }}</b-badge>
    </div>
    <div slot="modal-ok">
      <b-button variant="primary" @click="onCreateGroup">Submit</b-button>
    </div>
  </b-modal>
</template>
<script>
    export default {
      data(){
        return {
          name: '',
        }
      },
      methods: {
        onCreateGroup(){
          const users = [];
          this.$store.state.contactsSelected
            .map((elem) => elem.users[0])
            .forEach((elem) => users.push({id: elem}));

          users.push({id: this.$store.state.user.id});

          const params = {
              'name': this.name,
              'users': users,
          };

          axios.post('/messenger/api/conversations', params)
            .then((response) => {
              if (response.data.success) {
                this.$store.dispatch('getConversations', this.$store.state.user);
              }
          })
          .catch(function (error) {
              console.log(error);
          });
        }
      },
      computed: {
      }
    }
</script>