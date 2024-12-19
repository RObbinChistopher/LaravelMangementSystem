import axios from 'axios'
import config from '../../config'
const TaskModule = {
    namespaced: true,
    state() {
        return {
            pagination: null,
            tasks: [],
            tasksLoading: false,
            singleTasks: [],
            singleTasksLoading: false,
        }
    },
    mutations: {
        SET_PAGINATION(state, page) {
            state.pagination = page
        },
        SET_TASK(state, data){
            state.tasks = data
        },
        SET_TASK_LOADING(state, data){
            state.tasksLoading = data
        },
        SET_SINGLE_TASK(state, data){
            state.singleTasks = data
        },
        SET_SINGLE_TASK_LOADING(state, data){
            state.singleTasksLoading = data
        },
    },
    actions: {
        async fetchAllTasks({ commit }, page_number) {
            let url = config.apiBaseUrl + `show-tasks?page=${page_number}`;
            const token = localStorage.getItem('token');
            try {
                commit('SET_TASK_LOADING', true)
                let response = await axios.get(url, {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                    }
                });
                commit('SET_TASK', response.data.data);
                commit('SET_PAGINATION', response.data.meta);
                commit('SET_TASK_LOADING', false)
            } catch (error) {
                console.log('error', error);
                commit('SET_TASK_LOADING', false);
            }
        },
        async fetchTasksSearch({ commit }, {query}) {
            let url = config.apiBaseUrl + `search-task`;
            const token = localStorage.getItem('token');
            try {
                commit('SET_TASK_LOADING', true)
                let response = await axios.post(url, { query }, {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                    }
                });
                commit('SET_TASK', response.data.data);
                commit('SET_TASK_LOADING', false)
            } catch (error) {
                console.log('error', error);
                commit('SET_TASK_LOADING', false);
            }
        },
        async fetchFilttleTasks({ commit }, {tasks,page_number}) {
            let url = config.apiBaseUrl + `filttle-tasks/${tasks}?page=${page_number}`;
            const token = localStorage.getItem('token');
            try {
                commit('SET_TASK_LOADING', true)
                let response = await axios.get(url, {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                    }
                });
                commit('SET_TASK', response.data.data);
                commit('SET_PAGINATION', response.data.meta);
                commit('SET_TASK_LOADING', false)
            } catch (error) {
                console.log('error', error);
                commit('SET_TASK_LOADING', false);
            }
        },
        async fetchSingleTasks({ commit }, id) {
            let url = config.apiBaseUrl + `edit-tasks/${id}`;
            const token = localStorage.getItem('token');
            try {
                commit('SET_SINGLE_TASK_LOADING', true)
                let response = await axios.get(url, {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                    }
                });
                commit('SET_SINGLE_TASK', response.data.data);
                commit('SET_SINGLE_TASK_LOADING', false)
            } catch (error) {
                console.log('error', error);
                commit('SET_SINGLE_TASK_LOADING', false);
            }
        },
        async fetchSingleTasksDelete({ commit }, payload) {
            let url = config.apiBaseUrl + `delete-tasks/${payload}`;
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
    },

}

export default TaskModule;