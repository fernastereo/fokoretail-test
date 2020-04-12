import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        messages: [],
        selectedConversation: null,
        conversations: [],
        querySearch: '',
        user: null,
        contactsSelected: [],
    },
    mutations: {
        activeUser(state, user){
            state.user = user;
        },
        newMessagesList(state, messages) {
            state.messages = messages;
        },
        addMessage(state, message) {
            const conversation = state.conversations.find( (conversation) => {
                return conversation.id == message.conversation_id; 
            });

            const author = state.user.id === message.user_id ? 'You' : conversation.name;
            
            conversation.last_message = `${author}: ${message.content}`;
            conversation.last_time = message.created_at;

            if(state.selectedConversation.id == message.conversation_id) {
                state.messages.push(message);
            }
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
        addContactsToGroup(state, contactSelected){
            state.contactsSelected = contactSelected;
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
        postMessage(context, newMessage) {
            const params = {
                'conversation_id': context.state.selectedConversation.id,
                'content': newMessage
            };
            
            axios.post('/api/messages', params)
            .then((response) => {
                if(response.data.success){
                    const message = response.data.message;
                    message.written_by_me = true;
                
                    context.commit('addMessage', message);
                }
            });
        }
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