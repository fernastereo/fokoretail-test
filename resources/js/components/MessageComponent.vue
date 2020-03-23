<template>
  <b-media :right-align="writtenByMe" vertical-align="center" class="mb-2">
    <template v-slot:aside>
      <b-img rounded="circle" :src=getAvatar width="50" height="50" blank-color="#ccc" alt="placeholder"></b-img>
    </template>
    <b-card no-body>
      <p class="mb-0 small p-2">
        <slot></slot>
      </p>
    </b-card>
  </b-media>
</template>

<script>
    export default {
      props: {
        'writtenByMe': Boolean,
        'myAvatar': String,
        'contactAvatar': String,
      },
      data(){
        return {
          
        }
      },
      mounted() {
      },
      computed: {
        getAvatar(){
          return this.writtenByMe ? this.myAvatar : this.contactAvatar;
        }
    }
    }
</script>