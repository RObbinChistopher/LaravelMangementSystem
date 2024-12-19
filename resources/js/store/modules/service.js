import axios from 'axios'
import config from '../../config'
const ServiceModule = {
    namespaced: true,
    state() {
        return {
            pagination: null,
            service: [],
            servicesLoading: false,
            singleService: [],
            singleServicesLoading: false,
        }
    },

    mutations: {
        SET_PAGINATION(state, page) {
            state.pagination = page
        },
        SET_SERVICES(state, data) {
            state.service = data
        },
        SET_SERVICES_LOADING(state, data) {
            state.servicesLoading = data
        },
        SET_SINGLE_SERVICES(state, data) {
            state.singleService = data
        },
        SET_SINGLE_SERVICES_LOADING(state, data) {
            state.singleServicesLoading = data
        },
    },

    actions: {
        async fetchAllServices({ commit }, page_number) {
            let url = config.apiBaseUrl + `show-services?page=${page_number}`;
            const token = localStorage.getItem('token');
            try {
                commit('SET_SERVICES_LOADING', true)
                let response = await axios.get(url, {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                    }
                });
                commit('SET_SERVICES', response.data.data);
                commit('SET_PAGINATION', response.data.meta);
                commit('SET_SERVICES_LOADING', false);
            } catch (error) {
                console.log('error', error);
                commit('SET_SERVICES_LOADING', false);
            }
        },
        async fetchSingleServices({ commit }, id) {
            let url = config.apiBaseUrl + `edit-services/${id}`;
            const token = localStorage.getItem('token');
            try {
                commit('SET_SINGLE_SERVICES_LOADING', true)
                let response = await axios.get(url, {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                    }
                });
                commit('SET_SINGLE_SERVICES', response.data.data);
                commit('SET_SINGLE_SERVICES_LOADING', false);
            } catch (error) {
                console.log('error', error);
                commit('SET_SINGLE_SERVICES_LOADING', false);
            }
        },
        async fetchdeleteServices({ commit }, id) {
            let url = config.apiBaseUrl + `delete-services/${id}`;
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
        async fetchFilttleByServices({ commit }, {service,page_number}) {
            let url = config.apiBaseUrl + `filttle-services/${service}/?page=${page_number}`;
            const token = localStorage.getItem('token');
            try {
                commit('SET_SERVICES_LOADING', true)
                let response = await axios.get(url, {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                    }
                });
                commit('SET_SERVICES', response.data.data);
                commit('SET_PAGINATION', response.data.meta);
                commit('SET_SERVICES_LOADING', false);
            } catch (error) {
                console.log('error', error);
                commit('SET_SERVICES_LOADING', false);
            }
        },
        async fetchFilttleByServicesStatus({ commit }, {status,page_number}) {
            let url = config.apiBaseUrl + `filttle-services-status/${status}/?page=${page_number}`;
            const token = localStorage.getItem('token');
            try {
                commit('SET_SERVICES_LOADING', true)
                let response = await axios.get(url, {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                    }
                });
                commit('SET_SERVICES', response.data.data);
                commit('SET_PAGINATION', response.data.meta);
                commit('SET_SERVICES_LOADING', false);
            } catch (error) {
                console.log('error', error);
                commit('SET_SERVICES_LOADING', false);
            }
        },
        async fetchFilttleByServicesSearch({ commit }, { query }) {
            let url = config.apiBaseUrl + `service-search`;
            const token = localStorage.getItem('token');
            try {
                commit('SET_SERVICES_LOADING', true)
                let response = await axios.post(url, {query} , {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                    }
                });
                commit('SET_SERVICES', response.data.data);
                commit('SET_SERVICES_LOADING', false);
            } catch (error) {
                console.log('error', error);
                commit('SET_SERVICES_LOADING', false);
            }
        },
        async fetchMessageOnEndPackage({ commit }) {
            let url = config.apiBaseUrl + `alert-message-package`;
            const token = localStorage.getItem('token');
            try {
                commit('SET_SERVICES_LOADING', true)
                let response = await axios.get(url, {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                    }
                });
                commit('SET_SERVICES', response.data.data);
                commit('SET_SERVICES_LOADING', false);
            } catch (error) {
                console.log('error', error);
                commit('SET_SERVICES_LOADING', false);
            }
        },
    },
};

export default ServiceModule;