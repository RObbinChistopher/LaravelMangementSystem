import axios from 'axios'
import config from '../../config'
const notificationModule = {
    namespaced: true,
    state() {
        return {
            pagination: null,
            notification: [],
            notificationLoading: false,
            singleNotification: [],
            singleNotificationLoading: false,
        }
    },
    mutations: {
        SET_PAGINATION(state, page) {
            state.pagination = page
        },
        SET_NOTIFICATION(state, data)
        {
            state.notification = data
        },
        SET_NOTIFICATION_LOADING(state, data)
        {
            state.notificationLoading = data
        },
        SET_SINGLE_NOTIFICATION(state, data)
        {
            state.singleNotification = data
        },
        SET_SINGLE_NOTIFICATION_LOADING(state, data)
        {
            state.singleNotificationLoading = data
        },
    },
    actions: {
        async fetchAllNotification({ commit }, page_number) {
            let url = config.apiBaseUrl + `show-notification?page=${page_number}`;
            const token = localStorage.getItem('token');
            try {
                commit('SET_NOTIFICATION_LOADING', true)
                let response = await axios.get(url, {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                    }
                });
                commit('SET_NOTIFICATION', response.data.data);
                commit('SET_PAGINATION', response.data.meta);
                commit('SET_NOTIFICATION_LOADING', false)
            } catch (error) {
                console.log('error', error)
            }
        },
        async fetchSingleNotification({ commit }, id) {
            let url = config.apiBaseUrl + `edit-notification/${id}`;
            const token = localStorage.getItem('token');
            try {
                commit('SET_SINGLE_NOTIFICATION_LOADING', true)
                let response = await axios.get(url, {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                    }
                });
                commit('SET_SINGLE_NOTIFICATION', response.data.data);
                commit('SET_SINGLE_NOTIFICATION_LOADING', false)
            } catch (error) {
                console.log('error', error)
            }
        },
        async fetchDeleteNotification({ commit }, id) {
            let url = config.apiBaseUrl + `delete-notification/${id}`;
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
        async fetchSearchNotification({ commit }, query) {
            let url = config.apiBaseUrl + `search-notification`;
            const token = localStorage.getItem('token');
            try {
                commit('SET_NOTIFICATION_LOADING', true)
                let response = await axios.post(url, {query} ,{
                    headers: {
                        'Authorization': `Bearer ${token}`,
                    }
                });
                commit('SET_NOTIFICATION', response.data.data);
                commit('SET_PAGINATION', response.data.meta);
                commit('SET_NOTIFICATION_LOADING', false)
            } catch (error) {
                console.log('error', error)
                commit('SET_NOTIFICATION_LOADING', false)
            }
        },
    }
};


export default notificationModule;

