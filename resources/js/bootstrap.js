import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

// Assigna Pusher a window per si algun altre script el necessita
window.Pusher = Pusher;

// Inicialitza Echo
const echoInstance = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    authEndpoint: '/broadcasting/auth',
});

// Assigna a window per accedir des de la consola
window.Echo = echoInstance;

document.addEventListener('DOMContentLoaded', function () {
    const userId = document.querySelector('meta[name="user-id"]')?.getAttribute('content');
    const list = document.getElementById('notifications');

    window.Echo.private(`App.Models.User.${userId}`)
        .notification((notification) => {
            console.log("Notificació rebuda!", notification);
            const li = document.createElement('li');
            li.textContent = `${notification.title}: ${notification.message}`;
            list.prepend(li);
        });
});

