<template>
    <b-list-group-item class="p-0" :variant="variant">
        <b-row class="p-0">
            <b-col cols="12" md="3" class="text-center">
                <b-img rounded="circle" src="https://picsum.photos/250/250" width="50" height="50" blank-color="#777" alt="img" class="m-1"></b-img>
            </b-col>
            <b-col cols="6" align-self="center" class="d-none d-md-block">
                <p class="mb-0">{{ name }}</p>
                <p class="text-muted small mb-0">{{ lastMessage }}</p>
            </b-col>
            <b-col cols="3" class="d-none d-md-block">
                <p class="text-muted small mt-1">{{ lastTime }}</p>
            </b-col>
        </b-row>        
    </b-list-group-item>
</template>

<script>
    export default {
      props: [
        'variant'
      ],
      data(){
        return {
          name: 'Carlos Bacca',
          lastMessage: 'Proximo Partido en abril',
          lastTime: '10:56 a.m.',
        }
      },
      mounted() {
          console.log('Component mounted.')
      }
    }
</script>