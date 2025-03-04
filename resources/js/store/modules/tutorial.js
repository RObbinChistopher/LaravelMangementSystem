import axios from 'axios'
import config from '../../config'
const tutorialModule = {
    namespaced: true,
    state() {
        return {
            url: [],
            urlLoading: false,
            singleUrl: [],
            singleUrlLoading: false,
        }
    },
    mutations: {
        SET_URL(state, data) {
            state.url = data
        },
        SET_URL_LOADING(state, data) {
            state.urlLoading = data
        },
        SET_SINGLE_URL(state, data) {
            state.singleUrl = data
        },
        SET_SINGLE_URL_LOADING(state, data) {
            state.singleUrlLoading = data
        },
    },
    actions: {
        async fetchTutorial({ commit }) {
            let url = config.apiBaseUrl + `show-tutorial`;
            const token = localStorage.getItem('token');
            try {
                commit('SET_URL_LOADING', true)
                let response = await axios.get(url, {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                    }
                });
                commit('SET_URL', response.data);
                commit('SET_URL_LOADING', false)
            } catch (error) {
                console.log('error', error)
            }
        },
        async fetchSingleTutorial({ commit }, id) {
            let url = config.apiBaseUrl + `edit-tutorial/${id}`;
            const token = localStorage.getItem('token');
            try {
                commit('SET_SINGLE_URL_LOADING', true)
                let response = await axios.get(url, {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                    }
                });
                commit('SET_SINGLE_URL', response.data);
                commit('SET_SINGLE_URL_LOADING', false)
            } catch (error) {
                console.log('error', error)
            }
        },
        async fetchDeleteTutorial({ commit }, id) {
            let url = config.apiBaseUrl + `delete-tutorial/${id}`;
            const token = localStorage.getItem('token');
            try {
                let response = await axios.delete(url, {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                    }
                });
            } catch (error) {
                console.log('error', error)
            }
        },
    },
};
export default tutorialModule;