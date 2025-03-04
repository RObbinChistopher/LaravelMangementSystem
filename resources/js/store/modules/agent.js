import axios from 'axios'
import config from '../../config'
const agentModule = {
    namespaced: true,
    state() {
        return {
            pagination: null,
            userAgent: [],
            userAgentLoading: false,
            agent: [],
            agentLoading: false,
            singleAgent: [],
            singleAgentLoading: false,
        }
    },
    mutations: {
        SET_PAGINATION(state, page) {
            state.pagination = page
        },
        SET_USER_AGENT(state, data){
            state.userAgent = data;
        },
        SET_USER_AGENT_LOADING(state, data){
            state.userAgentLoading = data;
        },
        SET_AGENT(state, data){
            state.agent = data;
        },
        SET_AGENT_LOADING(state, data){
            state.agentLoading = data;
        },
        SET_SINGLE_AGENT(state, data){
            state.singleAgent = data;
        },
        SET_SINGLE_AGENT_LOADING(state, data){
            state.singleAgentLoading = data;
        },
    },
    actions: {
        async fetchAllAffiliateClientAdmin({ commit }, page_number) {
            let url = config.apiBaseUrl + `show-affiliate-client?page=${page_number}`;
            const token = localStorage.getItem('token');
            try {
                commit('SET_AGENT_LOADING', true)
                let response = await axios.get(url, {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                    }
                });
                commit('SET_AGENT', response.data.data);
                commit('SET_PAGINATION', response.data.meta);
                commit('SET_AGENT_LOADING', false);
            } catch (error) {
                console.log('error', error);
                commit('SET_AGENT_LOADING', false);
            }
        },
        async fetchEditAffiliateClientAdmin({ commit }, id) {
            let url = config.apiBaseUrl + `edit-affiliate-client/${id}`;
            const token = localStorage.getItem('token');
            try {
                commit('SET_SINGLE_AGENT_LOADING', true)
                let response = await axios.get(url, {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                    }
                });
                commit('SET_SINGLE_AGENT', response.data.data);
                commit('SET_SINGLE_AGENT_LOADING', false);
            } catch (error) {
                console.log('error', error);
                commit('SET_SINGLE_AGENT_LOADING', false);
            }
        },
        async fetchAffiliatePaymentRange({ commit }) {
            let url = config.apiBaseUrl + `affiliate-payment-range`;
            const token = localStorage.getItem('token');
            try {
                commit('SET_AGENT_LOADING', true)
                let response = await axios.get(url, {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                    }
                });
                commit('SET_AGENT', response.data);
                commit('SET_AGENT_LOADING', false);
            } catch (error) {
                console.log('error', error);
                commit('SET_AGENT_LOADING', false);
            }
        },
        async fetchdDeleteAffiliateClientAdmin({ commit }, id) {
            let url = config.apiBaseUrl + `delete-affiliate-client/${id}`;
            const token = localStorage.getItem('token');
            try {
                let response = await axios.delete(url, {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                    }
                });
            } catch (error) {
                console.log('error', error);
            }
        },
        async fetchAffiliateClientAdminSearch({ commit }, query) {
            let url = config.apiBaseUrl + `affiliate-client-search`;
            const token = localStorage.getItem('token');
            try {
                commit('SET_AGENT_LOADING', true);
                let response = await axios.post(url, { query }, {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                    }
                });
                commit('SET_AGENT', response.data.data);
                commit('SET_AGENT_LOADING', false);
            } catch (error) {
                console.log('error', error);
                commit('SET_AGENT_LOADING', false);
            }
        },

        // user Affiliate client
        async fetchUserAffiliateClient({ commit }, page_number) {
            let url = config.apiBaseUrl + `show-user-affiliate-client?page=${page_number}`;
            const token = localStorage.getItem('token');
            try {
                commit('SET_USER_AGENT_LOADING', true)
                let response = await axios.get(url, {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                    }
                });
                commit('SET_USER_AGENT', response.data.data);
                commit('SET_PAGINATION', response.data.meta);
                commit('SET_USER_AGENT_LOADING', false);
            } catch (error) {
                console.log('error', error);
                commit('SET_USER_AGENT_LOADING', false);
            }
        },
        async fetchUserPaymentStatus({ commit }) {
            let url = config.apiBaseUrl + `show-business-payment-status`;
            const token = localStorage.getItem('token');
            try {
                commit('SET_USER_AGENT_LOADING', true)
                let response = await axios.get(url, {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                    }
                });
                commit('SET_USER_AGENT', response.data.data);
                commit('SET_USER_AGENT_LOADING', false);
            } catch (error) {
                console.log('error', error);
                commit('SET_USER_AGENT_LOADING', false);
            }
        },
        async fetchBusinessInformationForAdmin({ commit }) {
            let url = config.apiBaseUrl + `business-information-client`;
            const token = localStorage.getItem('token');
            try {
                let response = await axios.get(url, {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                    }
                });
                commit('SET_USER_AGENT', response.data);
            } catch (error) {
                console.log('error', error);
            }
        },
    },
};
export default agentModule;