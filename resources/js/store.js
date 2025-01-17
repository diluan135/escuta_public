import axios from 'axios';
import { createStore } from 'vuex';

export default createStore({
    state() {
        return {
            currentView: 'novaSolicitacao',
            user: null, 
            chats: [],
            FAQ: [],
        };
    },
    mutations: {
        setCurrentView(state, view) {
            state.currentView = view;
        },
        setUser(state, user) {
            state.user = user;
        },
        setChats(state, chats) {
            state.chats = chats;
        },
        setFAQ(state, FAQ) {
            state.FAQ = FAQ;
        },
    },
    actions: {
        async fetchUser({ commit }) {
            try {
                const response = await axios.get('/api/user');
                commit('setUser', response.data);
            } catch (error) {
                console.error('Failed to fetch user', error);
            }
        },
        async fetchChats({ commit, state }) {
            if (!state.user) {
                try {
                    await this.dispatch('fetchUser');
                } catch (error) {
                    console.error('Failed to fetch user before fetching chats', error);
                    return;
                }
            }
            
            try {
                const response = await axios.get('/api/chat', {
                    params: {
                        usuario_id: state.user.id,
                    },
                });
                commit('setChats', response.data);
            } catch (error) {
                console.error('Failed to fetch chats', error);
            }
        },
        async fetch({ commit, state }) {
            try {
                const response = await axios.get('/api/FAQ/get');
                commit('setFAQ', response.data);
            } catch (error) {
                console.error('Failed to fetch FAQ', error);
            }
        }
    },
});
