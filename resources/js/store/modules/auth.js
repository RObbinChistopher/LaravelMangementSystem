import axios from 'axios'
import config from '../../config'
const authModule = {
    namespaced: true,
    state() {
        return {
            token: localStorage.getItem('token') || null,
            user: null,
            isAuthenticated: true,
            pagination: null,
            singleUser: [],
            singleUserLoading: false,
            allUser: [],
            passwordLoading : false,
            profile: [],
            profileLoading: false
        }
    },

    mutations: {
        SET_PAGINATION(state, page) {
            state.pagination = page
        },
        SET_TOKEN(state, token) {
            state.token = token;
            localStorage.setItem('token', token);
        },
        SET_USER_LOADING(state, loading) {
            state.userLoading = loading;
        },
        SET_USER(state, user) {
            state.user = user;
        },
        SET_AUTH_STATUS(state, isAuthenticated) {
            state.isAuthenticated = isAuthenticated;
        },
        SET_SINGLE_USER(state, data) {
            state.singleUser = data;
        },
        SET_SINGLE_USER_LOADING(state, data) {
            state.singleUserLoading = data;
        },
        SET_ALL_USER(state, data) {
            state.allUser = data
        },
        UPDATE_USER_PASSWORD(state, newPassword) {
            state.user.password = newPassword;
        },
        SET_PASSWORD_LOADING(state, loading){
            state.passwordLoading = loading
        },
        SET_PROFILE(state, data){
            state.profile = data
        },

        SET_PROFILE_LOADING(state, data){
            state.profileLoading = data
        }
    },

    actions: {
        async fetchGetAllUsers({ commit }) {
            let url = config.apiBaseUrl + `all-users`;
            const token = localStorage.getItem('token');
            try {
                let response = await axios.get(url, {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                    }
                });
                commit('SET_ALL_USER', response.data.data);
            } catch (error) {
                console.log('error', error)
            }
        },
        async login({ commit }, credentials) {
            try {
                const response = await axios.post(config.apiBaseUrl + 'login', credentials);
                console.log('Response data:', response.data);

                if (response.data.token) {
                    commit('SET_TOKEN', response.data.token);
                    commit('SET_AUTH_STATUS', true);
                    localStorage.setItem('role', response.data.user.role);
                    localStorage.setItem('token', response.data.token);

                    return { success: true, message: 'Login successful', user: response.data.user };
                } else {
                    throw new Error('Token not found in response');
                }
            } catch (error) {
                console.error('Login failed', error);
                return { success: false, message: 'Login failed', error };
            }
        },
        async deleteUsers({ commit }, payload) {
            let url = `${config.apiBaseUrl}delete-user/${payload}`;
            const token = localStorage.getItem('token');
            try {
                let response = await axios.delete(url, {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                    }
                });
                console.log('Delete Response:', response);
            } catch (error) {
                console.error('Error during delete request:', error);
            }
        },
        logout({commit}) {
            commit('SET_TOKEN', null);
            commit('SET_USER', null);
            commit('SET_AUTH_STATUS', false);
            localStorage.removeItem('token');
            localStorage.removeItem('role');
        },

        async fetchAllUsers({ commit }, page_number) {
            let url = config.apiBaseUrl + `users?page=${page_number}`;
            const token = localStorage.getItem('token');
            try {
                commit('SET_AUTH_STATUS', true)
                let response = await axios.get(url, {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                    }
                });
                commit('SET_USER', response.data.data);
                commit('SET_PAGINATION', response.data.meta);
                commit('SET_AUTH_STATUS', false)
            } catch (error) {
                console.log('error', error)
            }
        },
        async fetchUserSearch({ commit }, { query }) {
            const url = `${config.apiBaseUrl}user-search`;
            const token = localStorage.getItem('token');

            try {
                commit('SET_AUTH_STATUS', true);

                const response = await axios.post(url, {
                    'query': query,
                }, {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Content-Type': 'application/json'
                    }
                });
                commit('SET_USER', response.data.data);
                commit('SET_AUTH_STATUS', false);
                return response;
            } catch (error) {
                console.error('Error fetching Users:', error);
                commit('SET_AUTH_STATUS', false);
            }
        },
        async FilterByUserRole({ commit }, { role, page_number }) {
            const url = `${config.apiBaseUrl}filter-role/${role}?page=${page_number}`;
            const token = localStorage.getItem('token');

            try {
                commit('SET_AUTH_STATUS', true);

                const response = await axios.get(url, {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Content-Type': 'application/json'
                    }
                });
                commit('SET_USER', response.data.data);
                commit('SET_PAGINATION', response.data.meta);
                commit('SET_AUTH_STATUS', false);
                return response;
            } catch (error) {
                console.error('Error fetching Users:', error);
                commit('SET_AUTH_STATUS', false);
            }
        },
        async fetchSingleUsers({ commit }, id) {
            let url = config.apiBaseUrl + `edit-user/${id}`;
            const token = localStorage.getItem('token');
            try {
                commit('SET_SINGLE_USER_LOADING', true)
                let response = await axios.get(url, {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                    }
                });
                commit('SET_SINGLE_USER', response.data.data);
                commit('SET_SINGLE_USER_LOADING', false)
            } catch (error) {
                console.log('error', error)
            }
        },

        async fetchloginUser({commit}) {
            let url = config.apiBaseUrl + `login-user`;
            const token = localStorage.getItem('token');
            try {
                commit('SET_PROFILE_LOADING', true)
                let response = await axios.get(url, {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                    }
                });
                commit('SET_PROFILE', response.data.data);
                commit('SET_PROFILE_LOADING', false)
            } catch (error) {
                console.log('error', error)
            }
        },
        async updatePassword({commit}, password) {
            const url =  config.apiBaseUrl + `user-password-update`
            const token = localStorage.getItem('token');
            try {
                commit('SET_PASSWORD_LOADING', true)
                  let response  = await axios.post(url, {password: password}, {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                    }
                })
                commit('UPDATE_USER_PASSWORD', response)
                commit('SET_PASSWORD_LOADING', false)
                toast.success('Password Update Successfully!');
            } catch (errors){
                console.log(errors)
                commit('SET_PASSWORD_LOADING', false)
            }
          },


    },

    getters: {
        // Getter functions to access authentication state
        getToken: state => state.token,
        getUser: state => state.user,
        isAuthenticated: state => state.isAuthenticated
    },
};

export default authModule;
