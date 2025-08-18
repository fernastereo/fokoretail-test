<template>
  <b-media :right-align="writtenByMe" vertical-align="center" class="mb-2">
    <template v-slot:aside>
        <div class="userBadge">
            <b-img rounded="circle" :src=getAvatar width="50" height="50" blank-color="#ccc" alt="placeholder"></b-img>
        </div>
    </template>
    <b-card no-body>
      <div>
        <p class="mb-0 small p-2">
          <slot></slot>
        </p>
        <small class="float-right mb-1 mr-1"><b-badge pill variant="info">{{this.messageCreatedAt}}</b-badge></small>
      </div>
    </b-card>

  </b-media>
</template>
<script>
    export default {
        props: {
            'user_id': Number,
            'written_by': String,
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
                const contactImage = this.contactAvatar ? this.contactAvatar : this.$store.state.defaultImagePath + 'default.png';
                return contactImage;
            },
        }
    }
</script>
<style scoped>
    .userBadge {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }
    .userName {
        font-size: 10px;
        max-width: 60px;
        line-height: 10px;
        font-weight: 500;
    }
</style>
