// src/config.js
const config = {
    productions: {
        apiBaseUrl: 'http://51.20.181.199/api/'
    }
};

// Manually select the environment
const environment = 'productions'; // Change to 'development' for development

export default config[environment];

// success we pass