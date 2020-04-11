/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Vue from 'vue';
import Vuex from 'vuex';
import BootstrapVue from 'bootstrap-vue';

Vue.use(BootstrapVue);
Vue.use(Vuex);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('chat-component', require('./components/ChatComponent.vue').default);
Vue.component('contact-component', require('./components/ContactComponent.vue').default);
Vue.component('contact-form-component', require('./components/ContactFormComponent.vue').default);
Vue.component('contact-list-component', require('./components/ContactListComponent.vue').default);
Vue.component('active-conversation-component', require('./components/ActiveConversationComponent.vue').default);
Vue.component('message-component', require('./components/MessageComponent.vue').default);
Vue.component('status-component', require('./components/StatusComponent.vue').default);
Vue.component('profile-component', require('./components/ProfileComponent.vue').default);
Vue.component('invitation-form-component', require('./components/InvitationFormComponent.vue').default);
Vue.component('invitations-component', require('./components/InvitationsComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const store = new Vuex.Store({
    state: {
        // user: null,
        messages: [],
        selectedConversation: null,
        conversations: [],
        querySearch: '',
    },
    mutations: {
        // activeUser(state, user){
        //     state.user = user;
        // },
        newMessagesList(state, messages) {
            state.messages = messages;
        },
        addMessage(state, message) {
            state.messages.push(message);
        },
        conversationSelected(state, conversation){
            state.selectedConversation = conversation;
        },
        newQuerySearch(state, newValue){
            state.querySearch = newValue;
        },
        newConversationsList(state, conversations) {
            state.conversations = conversations;
        },
    },
    actions: {
        getMessages(context, conversation){
            axios.get(`/api/messages/${conversation.id}`)
                .then((response) => {
                    context.commit('conversationSelected', conversation);
                    context.commit('newMessagesList', response.data);
            });
        },  
        getConversations(context, user){
            axios.get(`/api/users/${user.id}/conversations`)
                .then((response) => {
                    context.commit('newConversationsList', response.data);
                }
            );
        },  
    },
    getters: {
        filteredConversations(state){
            return state.conversations.filter((conversation) => conversation.name.toLowerCase().includes(state.querySearch.toLowerCase()));
        },
        filteredConversationsForGroups(state){
            return state.conversations.filter((conversation) => conversation.users.length == 1);
        },      
    }
});

const app = new Vue({
    el: '#app',
    store,
    methods: {
        logout() {
            document.getElementById('logout-form').submit();
        }
    }
});
