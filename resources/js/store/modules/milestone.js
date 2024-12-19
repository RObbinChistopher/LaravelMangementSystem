import axios from 'axios'
import config from '../../config'
const milestoneModule = {
    namespaced: true,
    state() {
        return {
            pagination: null,
            mileStone: [],
            mileStoneLoading: false,
            singleMileStone: [],
            singleMileStoneLoading: false,
            allMileStone: [],
        }
    },
    mutations: {
        SET_PAGINATION(state, page) {
            state.pagination = page
        },
        SET_MILESTORE(state, data) {
            state.mileStone = data
        },
        SET_MILESTORE_LOADING(state, data) {
            state.mileStoneLoading = data
        },
        SET_SINGLE_MILESTONE(state, data) {
            state.singleMileStone = data
        },
        SET_SINGLE_MILESTONE_LOADING(state, data) {
            state.singleMileStoneLoading = data
        },
        SET_ALL_MILESTONE(state, data){
            state.allMileStone = data
        }
    },
    actions: {
        async fetchGetAllMilestores({ commit }) {
            let url = config.apiBaseUrl + `all-milestone`;
            const token = localStorage.getItem('token');
            try {
                let response = await axios.get(url, {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                    }
                });
                commit('SET_ALL_MILESTONE', response.data.data);
            } catch (error) {
                console.log('error', error);
            }
        },
        async fetchAllMilestores({ commit }, page_number) {
            let url = config.apiBaseUrl + `milestore?page=${page_number}`;
            const token = localStorage.getItem('token');
            try {
                commit('SET_MILESTORE_LOADING', true)
                let response = await axios.get(url, {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                    }
                });
                commit('SET_MILESTORE', response.data.data);
                commit('SET_PAGINATION', response.data.meta);
                commit('SET_MILESTORE_LOADING', false);
            } catch (error) {
                console.log('error', error);
                commit('SET_MILESTORE_LOADING', false);
            }
        },
        async fetchSingleMilestores({ commit }, id) {
            let url = config.apiBaseUrl + `edit-milestore/${id}`;
            const token = localStorage.getItem('token');
            try {
                commit('SET_SINGLE_MILESTONE_LOADING', true)
                let response = await axios.get(url, {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                    }
                });
                commit('SET_SINGLE_MILESTONE', response.data.data);
                commit('SET_SINGLE_MILESTONE_LOADING', false);
            } catch (error) {
                console.log('error', error);
                commit('SET_SINGLE_MILESTONE_LOADING', false);
            }
        },
        async fetchDeleteMilestores({ commit }, id) {
            let url = config.apiBaseUrl + `delete-milestore/${id}`;
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

        async fetchMilestoresStatus({ commit }, { page_number, status }) {
            let url = config.apiBaseUrl + `milestore-status/${status}?page=${page_number}`;
            const token = localStorage.getItem('token');
            try {
                commit('SET_MILESTORE_LOADING', true)
                let response = await axios.get(url, {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                    }
                });
                commit('SET_MILESTORE', response.data.data);
                commit('SET_PAGINATION', response.data.meta);
                commit('SET_MILESTORE_LOADING', false);
            } catch (error) {
                console.log('error', error);
                commit('SET_MILESTORE_LOADING', false);
            }
        },
        async fetchMilestoresSearch({ commit }, query) {
            let url = config.apiBaseUrl + `milestones-search`;
            const token = localStorage.getItem('token');
            try {
                commit('SET_MILESTORE_LOADING', true);
                let response = await axios.post(url, { query }, {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                    }
                });
                commit('SET_MILESTORE', response.data.data);
                commit('SET_MILESTORE_LOADING', false);
            } catch (error) {
                console.log('error', error);
                commit('SET_MILESTORE_LOADING', false);
            }
        },

    }
};

export default milestoneModule;