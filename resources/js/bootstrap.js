import _ from 'lodash'; // Usar import para lodash
window._ = _;

/**
 * We'll load the Axios HTTP library which provides a clean,
 * simple API for making HTTP requests to your Laravel application.
 */

import axios from 'axios'; // Usar import para axios
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// Se você estiver usando Laravel Echo, as importações também devem ser ES Modules:
// import Echo from 'laravel-echo';
// import Pusher from 'pusher-js'; // Importar Pusher
// window.Pusher = Pusher; // E atribuir a window.Pusher

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: import.meta.env.VITE_PUSHER_APP_KEY, // Variáveis de ambiente no Vite são import.meta.env
//     cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER ?? 'mt1',
//     forceTLS: true
// });
