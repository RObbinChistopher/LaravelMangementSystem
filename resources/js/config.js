// src/config.js
const config = {
    development: {
        apiBaseUrl: 'http://localhost:8000/api/'
    },
    production: {
        apiBaseUrl: 'http://51.20.181.199/api/'
    }
};

// Manually select the environment
const environment = 'production'; // Change to 'production' for production

export default config[environment];
