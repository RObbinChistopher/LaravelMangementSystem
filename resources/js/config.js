// src/config.js
const config = {
    development: {
        apiBaseUrl: 'http://localhost:8000/api/'
    },
    production: {
        apiBaseUrl: 'https://admin.420finder.net/api/'
    }
};

// Manually select the environment
const environment = 'development'; // Change to 'production' for production

export default config[environment];
