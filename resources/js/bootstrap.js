const { default: axios } = require('axios');

window._ = require('lodash');

try {
    require('bootstrap');
} catch (e) {}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     forceTLS: true
// });

axios.interceptors.request.use(
    config => {

        let token = document.cookie.split(';').find(index => index.includes('token=')) || '=';
        token = token.split('=')[1];

        config.headers.Authorization = `Bearer ${token}`;
        config.headers.Accept = 'application/json';

        return config;
    },
    error => {
        console.log('Erro no request: ', error);
        return Promise.reject(error);
    }
);

axios.interceptors.response.use(
    response => {
        return response;
    },
    error => {
        if(error.response.status === 401 && error.response.data.message === 'Token has expired') {
            alert('Ooops, seu token expirou!\n\nAo recarregar a página, tente novamente.')

            axios
                .post('http://127.0.0.1:8000/api/v1/refresh')
                .then(response => {
                    const data = response.data

                    if(!data.access_token) {
                        return Promise.reject(response);
                    }

                    document.cookie = `token=${data.access_token}`

                    location.reload();
                })
                .catch(error => {
                    return Promise.reject(error);
                })
        }

        return Promise.reject(error);
    }
);
