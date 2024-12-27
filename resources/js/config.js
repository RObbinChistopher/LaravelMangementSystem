// src/config.js
const config = {
    development: {
        apiBaseUrl: 'http://localhost:8000/api/'
    },
    productions: {
        apiBaseUrl: 'http://51.20.181.199/api/'
    }
};

const environment = 'productions';
console.log("Using API Base URL:", config[environment].apiBaseUrl);

export default config[environment];
