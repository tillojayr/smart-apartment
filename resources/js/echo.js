import Echo from 'laravel-echo';
import Pusher from 'pusher-js';
window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'reverb',
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: import.meta.env.VITE_REVERB_HOST,
    wsPort: import.meta.env.VITE_REVERB_PORT ?? 443,
    wssPort: import.meta.env.VITE_REVERB_PORT ?? 443,
    forceTLS: true,
    enabledTransports: ['ws', 'wss'],
    path: '/app/{appKey}' // Make sure this path matches your Nginx config
});

// window.Echo = new Echo({
//     broadcaster: 'reverb',
//     key: 'your-app-key',
//     wsHost: 'jayrtillo.online',
//     wsPort: 443,
//     wssPort: 443,
//     forceTLS: true,
//     enabledTransports: ['ws', 'wss'],
//     path: '/reverb/app/{appKey}' // Make sure this path matches your Nginx config
// });

// For testing the connection
window.Echo.connector.pusher.connection.bind('connected', () => {
    console.log('Connected to Reverb WebSocket');
});

window.Echo.connector.pusher.connection.bind('error', (err) => {
    console.error('Reverb connection error:', err);
});
