<template>
  <b-list-group class="list-scroll">
    <group-component 
      v-for="group in groups" 
      :key="group.id"
      :group="group"
      :selected="SelectedGroupId === group.id"
      @click.native="selectGroup(conversation)">
    </group-component>
  </b-list-group>
</template>
<style>
  .list-scroll{
    max-height: 280px;
    overflow-y: scroll;
    margin-bottom: 30px;
    overflow-x: hidden;
  }
</style>
<script>
    export default {
      props:{
        groups: Array,
      },
      data(){
        return {
          SelectedGroupId: null,
          contacts: [],
        }
      },
      mounted() {

      },
      methods: {
        selectGroup(group){
          // this.contacts.push(conversation)
          // this.$emit('contactsSelected', this.contacts);
          this.SelectedGroupId = group.id;
          this.$emit('groupSelected', group);
        }
      }
    }
</script>