// src/config.js
const config = {
    development: {
        apiBaseUrl: 'http://localhost:8000/api/'
    },
    productions: {
        apiBaseUrl: 'http://51.20.181.199/api/'
    }
};

// Manually select the environment (set 'productions' for production or 'development' for local development)
const environment = 'productions'; // Change to 'productions' for production

// Log the current environment and API URL for debugging
console.log("Using API Base URL:", config[environment].apiBaseUrl);

export default config[environment];
