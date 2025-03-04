import axios from 'axios'
import config from '../../config'
const supportModule = {
    namespaced: true,
    state() {
        return {
            pagination: null,
            Alltickets: [],
            AllticketsLoading: false,
            tickets: [],
            ticketsLoading: false,
            AllTicketsReply: [],
            AllTicketsReplyLoading: false,
            reply: [],
            ReplyLoading: false,
            ticketStatus: [],
            ticketStatusLoading: false,
        }
    },
    mutations: {
        SET_PAGINATION(state, page) {
            state.pagination = page
        },
        SET_ALL_TICKET(state, data) {
            state.Alltickets = data
        },
        SET_ALL_TICKET_LOADING(state, data) {
            state.AllticketsLoading = data
        },
        SET_TICKET(state, data) {
            state.tickets = data
        },
        SET_TICKET_LOADING(state, data) {
            state.ticketsLoading = data
        },
        SET_ALL_TICKET_REPLY(state, data) {
            state.AllTicketsReply = data
        },
        SET_ALL_TICKET_LOADING_REPLY(state, data) {
            state.AllTicketsReplyLoading = data
        },
        SET_TICKET_REPLY(state, data) {
            state.reply = data
        },
        SET_TICKET_LOADING_REPLY(state, data) {
            state.ReplyLoading = data
        },
        SET_TICKET_STATUS(state, data) {
            state.ticketStatus = data
        },
        SET_TICKET_LOADING_STATUS(state, data) {
            state.ticketStatusLoading = data
        },
    },
    actions: {
        async fetchShowTickets({ commit }, page_number) {
            let url = config.apiBaseUrl + `show-ticket?page=${page_number}`;
            const token = localStorage.getItem('token');
            try {
                commit('SET_TICKET_LOADING', true)
                let response = await axios.get(url, {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                    }
                });
                commit('SET_TICKET', response.data.data);
                commit('SET_PAGINATION', response.data.meta);
                commit('SET_TICKET_LOADING', false);
            } catch (error) {
                console.log('error', error);
                commit('SET_TICKET_LOADING', false);
            }
        },
        async fetchAllTickets({ commit }, page_number) {
            let url = config.apiBaseUrl + `show-all-ticket?page=${page_number}`;
            const token = localStorage.getItem('token');
            try {
                commit('SET_ALL_TICKET_LOADING', true)
                let response = await axios.get(url, {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                    }
                });
                commit('SET_ALL_TICKET', response.data.data);
                commit('SET_PAGINATION', response.data.meta);
                commit('SET_ALL_TICKET_LOADING', false);
            } catch (error) {
                console.log('error', error);
                commit('SET_ALL_TICKET_LOADING', false);
            }
        },
        async fetchAllTicketsReply({ commit }, id) {
            let url = config.apiBaseUrl + `get-ticket/${id}`;
            const token = localStorage.getItem('token');
            try {
                commit('SET_ALL_TICKET_LOADING_REPLY', true)
                let response = await axios.get(url, {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                    }
                });
                commit('SET_ALL_TICKET_REPLY', response.data.data);
                commit('SET_ALL_TICKET_LOADING_REPLY', false);
            } catch (error) {
                console.log('error', error);
                commit('SET_ALL_TICKET_LOADING_REPLY', false);
            }
        },
        async fetchTicketReply({ commit }, id) {
            let url = config.apiBaseUrl + `show-ticket-reply/${id}`;
            const token = localStorage.getItem('token');
            try {
                commit('SET_TICKET_LOADING_REPLY', true)
                let response = await axios.get(url, {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                    }
                });
                commit('SET_TICKET_REPLY', response.data.data);
                commit('SET_TICKET_LOADING_REPLY', false);
            } catch (error) {
                console.log('error', error);
                commit('SET_TICKET_LOADING_REPLY', false);
            }
        },
        async ticketStatusByAdmin({ commit }) {
            let url = config.apiBaseUrl + `ticket-status`;
            const token = localStorage.getItem('token');
            try {
                commit('SET_TICKET_LOADING_STATUS', true)
                let response = await axios.get(url, {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                    }
                });
                commit('SET_TICKET_STATUS', response.data);
                commit('SET_TICKET_LOADING_STATUS', false);
            } catch (error) {
                console.log('error', error);
                commit('SET_TICKET_LOADING_STATUS', false);
            }
        },
    }
};

export default supportModule;