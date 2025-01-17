import axios from 'axios'
import config from '../../config'
const projectModule = {
    namespaced: true,
    state() {
        return {
            pagination: null,
            project: [],
            projectLoading: false,
            singleProject: [],
            singleProjectLoading: false,
            allProject: false,
        }
    },
    mutations: {
        SET_PAGINATION(state, page) {
            state.pagination = page
        },
        SET_PROJECT(state, data) {
            state.project = data
        },
        SET_PROJECT_LOADING(state, data) {
            state.projectLoading = data
        },
        SET_SINGLE_PROJECT(state, data) {
            state.singleProject = data
        },
        SET_SINGLE_PROJECT_LOADING(state, data) {
            state.singleProjectLoading = data
        },
        SET_ALL_PROJECT(state, data) {
            state.allProject = data
        },
    },

    actions: {
        async fetchGetAllProjects({ commit }) {
            let url = config.apiBaseUrl + `get-all-porjects`;
            const token = localStorage.getItem('token');
            try {
                let response = await axios.get(url, {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                    }
                });
                commit('SET_ALL_PROJECT', response.data.data);
            } catch (error) {
                console.log('error', error)
            }
        },
        async fetchAllProjects({ commit }, page_number) {
            let url = config.apiBaseUrl + `projects?page=${page_number}`;
            const token = localStorage.getItem('token');
            try {
                commit('SET_PROJECT_LOADING', true)
                let response = await axios.get(url, {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                    }
                });
                commit('SET_PROJECT', response.data.data);
                commit('SET_PAGINATION', response.data.meta);
                commit('SET_PROJECT_LOADING', false)
            } catch (error) {
                console.log('error', error)
                commit('SET_PROJECT_LOADING', false)
            }
        },
        async fetchFilterProjects({ commit }, { percentage, page_number }) {
            let url = config.apiBaseUrl + `filter-percentage/${percentage}?page=${page_number}`;
            const token = localStorage.getItem('token');
            try {
                commit('SET_PROJECT_LOADING', true)
                let response = await axios.get(url, {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                    }
                });
                commit('SET_PROJECT', response.data.data);
                commit('SET_PAGINATION', response.data.meta);
                commit('SET_PROJECT_LOADING', false)
            } catch (error) {
                console.log('error', error)
                commit('SET_PROJECT_LOADING', false)
            }
        },
        async fetchProjectSearch({ commit }, { query }) {
            const url = `${config.apiBaseUrl}project-search`;
            const token = localStorage.getItem('token');

            try {
                commit('SET_PROJECT_LOADING', true);

                const response = await axios.post(url, {
                    'query': query,
                }, {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Content-Type': 'application/json'
                    }
                });
                commit('SET_PROJECT', response.data.data);
                commit('SET_PROJECT_LOADING', false);
                return response;
            } catch (error) {
                console.error('Error fetching Users:', error);
                commit('SET_PROJECT_LOADING', false);
            }
        },
        async fetchSingleProjects({ commit }, id) {
            let url = config.apiBaseUrl + `edit-project/${id}`;
            const token = localStorage.getItem('token');
            try {
                commit('SET_SINGLE_PROJECT_LOADING', true)
                let response = await axios.get(url, {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                    }
                });
                commit('SET_SINGLE_PROJECT', response.data.data);
                commit('SET_SINGLE_PROJECT_LOADING', false)
            } catch (error) {
                console.log('error', error)
                commit('SET_SINGLE_PROJECT_LOADING', false)
            }
        },
        async deleteProject({ commit }, payload) {
            let url = `${config.apiBaseUrl}delete-project/${payload}`;
            const token = localStorage.getItem('token');
            try {
                let response = await axios.delete(url, {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                    }
                });
            } catch (error) {
                console.error('Error during delete request:', error);
            }
        },
    }
};

export default projectModule;