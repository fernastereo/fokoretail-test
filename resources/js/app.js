require('./bootstrap');

import Vue from 'vue';
import BootstrapVue from 'bootstrap-vue';
import store from './store';

Vue.use(BootstrapVue);

//this library is used for notifications
import Toaster from 'v-toaster';
import 'v-toaster/dist/v-toaster.css';
Vue.use(Toaster, {timeout: 5000});

Vue.component('chat-component', require('./components/ChatComponent.vue').default);
Vue.component('contact-component', require('./components/ContactComponent.vue').default);
Vue.component('contact-form-component', require('./components/ContactFormComponent.vue').default);
Vue.component('contact-list-component', require('./components/ContactListComponent.vue').default);
Vue.component('create-group-component', require('./components/CreateGroupComponent.vue').default);
Vue.component('contact-group-list-component', require('./components/ContactGroupListComponent.vue').default);
Vue.component('active-conversation-component', require('./components/ActiveConversationComponent.vue').default);
Vue.component('message-component', require('./components/MessageComponent.vue').default);
Vue.component('status-component', require('./components/StatusComponent.vue').default);
Vue.component('profile-component', require('./components/ProfileComponent.vue').default);
Vue.component('invitation-form-component', require('./components/InvitationFormComponent.vue').default);
Vue.component('invitations-component', require('./components/InvitationsComponent.vue').default);

const app = new Vue({
    el: '#app',
    store,
    methods: {
        logout() {
            document.getElementById('logout-form').submit();
        }
    }
});
