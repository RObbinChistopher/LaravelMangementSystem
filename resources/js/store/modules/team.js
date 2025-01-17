import axios from 'axios'
import config from '../../config'
const teamModule = {
    namespaced: true,
    state() {
        return {
            pagination: null,
            allTeams: [],
            allTeamloading: false,
            teams: [],
            teamLoading: false,
            singleTeam: [],
            singleTeamloading: false,

            // teams member

            teamMember: [],
            teamMemberLoading: false,
            singleTeamMember: [],
            singleTeamMemberLoading: false,
        }
    },
    mutations: {
        SET_PAGINATION(state, page) {
            state.pagination = page
        },
        SET_TEAM(state, data) {
            state.teams = data
        },
        SET_TEAM_LOADING(state, data) {
            state.teamLoading = data
        },
        SET_SINGLE_TEAM(state, data) {
            state.singleTeam = data
        },
        SET_SINGLE_TEAM_LOADING(state, data) {
            state.singleTeamloading = data
        },
        SET_ALL_TEAMS(state, data) {
            state.allTeams = data
        },
        SET_ALL_TEAM_LOADING(state, data) {
            state.allTeamloading = data
        },

        // team member
        SET_TEAM_MEMBER(state, data) {
            state.teamMember = data
        },
        SET_TEAM_MEMBER_LOADING(state, data) {
            state.teamMemberLoading = data
        },
        SET_SINGLE_TEAM_MEMBER(state, data) {
            state.singleTeamMember = data
        },
        SET_SINGLE_TEAM_MEMBER_LOADING(state, data) {
            state.singleTeamMemberLoading = data
        },
    },
    actions: {
        async fetchAllTeams({ commit }, page_number) {
            let url = config.apiBaseUrl + `show-team?page=${page_number}`;
            const token = localStorage.getItem('token');
            try {
                commit('SET_TEAM_LOADING', true)
                let response = await axios.get(url, {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                    }
                });
                commit('SET_TEAM', response.data.data);
                commit('SET_PAGINATION', response.data.meta);
                commit('SET_TEAM_LOADING', false)
            } catch (error) {
                console.log('error', error)
            }
        },
        async showAllTeams({ commit }) {
            let url = config.apiBaseUrl + `show-all-team`;
            const token = localStorage.getItem('token');
            try {
                commit('SET_ALL_TEAM_LOADING', true)
                let response = await axios.get(url, {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                    }
                });
                commit('SET_ALL_TEAMS', response.data.data);
                commit('SET_ALL_TEAM_LOADING', false)
            } catch (error) {
                console.log('error', error)
            }
        },
        async fetchSingleTeam({ commit }, id) {
            let url = config.apiBaseUrl + `edit-team/${id}`;
            const token = localStorage.getItem('token');
            try {
                commit('SET_SINGLE_TEAM_LOADING', true)
                let response = await axios.get(url, {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                    }
                });
                commit('SET_SINGLE_TEAM', response.data.data);
                commit('SET_SINGLE_TEAM_LOADING', false)
            } catch (error) {
                console.log('error', error)
            }
        },

        async deleteSingleTeam({ commit }, id) {
            let url = config.apiBaseUrl + `delete-team/${id}`;
            const token = localStorage.getItem('token');
            try {
                commit('SET_SINGLE_TEAM_LOADING', true)
                let response = await axios.delete(url, {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                    }
                });
            } catch (error) {
                console.log('error', error)
            }
        },



        // team members


        async fetchAllTeamMembers({ commit }, { id, page_number }) {
            let url = config.apiBaseUrl + `show-team-membrs/${id}?page=${page_number}`;
            const token = localStorage.getItem('token');
            try {
                commit('SET_TEAM_MEMBER_LOADING', true)
                let response = await axios.get(url, {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                    }
                });
                commit('SET_TEAM_MEMBER', response.data.data);
                commit('SET_PAGINATION', response.data.meta);
                commit('SET_TEAM_MEMBER_LOADING', false)
            } catch (error) {
                console.log('error', error)
            }
        },
        async fetchSingleTeamMember({ commit }, id) {
            let url = config.apiBaseUrl + `edit-team-membrs/${id}`;
            const token = localStorage.getItem('token');
            try {
                commit('SET_SINGLE_TEAM_MEMBER_LOADING', true)
                let response = await axios.get(url, {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                    }
                });
                commit('SET_SINGLE_TEAM_MEMBER', response.data.data);
                commit('SET_SINGLE_TEAM_MEMBER_LOADING', false)
            } catch (error) {
                console.log('error', error)
            }
        },
        async deleteSingleTeamMember({ commit }, id) {
            let url = config.apiBaseUrl + `delete-team-membrs/${id}`;
            const token = localStorage.getItem('token');
            try {
                commit('SET_SINGLE_TEAM_LOADING', true)
                let response = await axios.delete(url, {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                    }
                });
            } catch (error) {
                console.log('error', error)
            }
        },
    }
};

export default teamModule;