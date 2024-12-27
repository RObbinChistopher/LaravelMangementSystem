import axios from 'axios'
import config from '../../config'
const dashboardModule = {
    namespaced: true,
    state() {
        return {
            dashboard: [],
            dashboardLoading: [],
        }
    },

    
    mutations: {
        SET_DASHBOARD_COUNT(state, data)
        {
            state.dashboard = data
        },
        SET_DASHBOARD_COUNT_LOADING(state, data)
        {
            state.dashboardLoading = data
        },
    },

    actions: {
       async fetchDashboardCount({commit})
        {
            let url = config.apiBaseUrl +  `show-count`;
            const token = localStorage.getItem('token');
            try {
                commit('SET_DASHBOARD_COUNT_LOADING', true)
                let response = await axios.get(url, {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                    }
                });
                commit('SET_DASHBOARD_COUNT', response.data);
                commit('SET_DASHBOARD_COUNT_LOADING', false);
            } catch (error) {
                console.log('error', error);
                commit('SET_DASHBOARD_COUNT_LOADING', false);
            }
        }
    }
};

export default dashboardModule;