// src/config.js
const config = {
    development: {
        apiBaseUrl: 'http://localhost:8000/api/'
    },
<<<<<<< HEAD
    production: {
        apiBaseUrl: 'https://admin.420finder.net/api/'
=======
    productions: {
        apiBaseUrl: 'http://51.20.181.199/api/'
>>>>>>> 1252dadd1d09e31bd361e3f7b4280864fbc18aa2
    }
};

// Manually select the environment
<<<<<<< HEAD
const environment = 'development'; // Change to 'production' for production
=======
const environment = 'productions'; // Change to 'production' for production
>>>>>>> 1252dadd1d09e31bd361e3f7b4280864fbc18aa2

export default config[environment];
