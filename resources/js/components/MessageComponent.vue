<template>
  <b-media :right-align="writtenByMe" vertical-align="center" class="mb-2">
    <template v-slot:aside>
      <b-img rounded="circle" :src=getAvatar width="50" height="50" blank-color="#ccc" alt="placeholder"></b-img>
    </template>
    <b-card no-body>
      <div>
        <p class="mb-0 small p-2">
          <slot></slot>
        </p>
        <small class="float-right mb-1 mr-1"><b-badge pill variant="info">{{messageCreatedAt}}</b-badge></small>
      </div>
    </b-card>
    
  </b-media>
</template>
<script>
    export default {
      props: {
        'writtenByMe': Boolean,
        'myAvatar': String,
        'contactAvatar': String,
        'createdAt': String,
      },
      computed: {
        messageCreatedAt(){
          return moment(this.createdAt).format('LLL');
        },
        getAvatar(){
          return this.writtenByMe ? this.myAvatar : this.contactAvatar;
        }
    }
    }
</script>