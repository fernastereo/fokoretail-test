<template>
    <b-list-group-item class="p-0" :variant="variant">
        <b-row class="p-0">
            <b-col cols="12" md="3" class="text-center">
                <b-img rounded="circle" :src=conversationAvatar width="50" height="50" blank-color="#777" alt="img" class="m-1"></b-img>
            </b-col>
            <b-col cols="6" align-self="center" class="d-none d-md-block">
                <p class="mb-0">
                    <!-- <status-component :online="conversation.online"></status-component> -->
                    {{ conversation.name }}
                </p>
                <p class="text-muted small mb-0">{{ conversation.last_message }}</p>
            </b-col>
            <b-col cols="3" class="d-none d-md-block">
                <p class="text-muted small mt-1">{{ lastTime }}</p>
            </b-col>
        </b-row>        
    </b-list-group-item>
</template>

<script>
    export default {
        props: {
            conversation: Object,
            selected: Boolean,
        },
        data(){
            return {

            }
        },
        mounted() {
            
        },
        computed: {
            lastTime(){
                return moment(this.conversation.last_time).fromNow();
            },
            variant(){
                return this.selected ? 'secondary': '';
            },
            conversationAvatar(){
                return '/storage/users/' + this.conversation.avatar;
            },
        }
    }
</script>