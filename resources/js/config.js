// src/config.js
const config = {
    development: {
        apiBaseUrl: 'http://localhost:8000/api/'
    },
    production: {
        apiBaseUrl: 'https://crm.visetech.us/api/'
    }
};

const environment = 'production';
console.log("Using API Base URL:", config[environment].apiBaseUrl);

export default config[environment];
