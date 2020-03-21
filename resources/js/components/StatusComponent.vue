<template >
  <b-img rounded="circle" blank width="10" height="10" 
    :title="online ? 'Online' : 'Offline'"
    :blank-color="online ? 'green' : 'red'" alt="img" class="m-1"></b-img>
</template>
<script>
  export default{
    props: {
      online: Boolean,
    },
    data(){
      return {

      };
    },
    mounted(){

    },
  }
</script>