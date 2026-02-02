import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();



import Echo from 'laravel-echo';
import Pusher from 'pusher-js';
import toastr from 'toastr';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    wsHost: window.location.hostname,
    wsPort: 6001,
    forceTLS: false,
    disableStats: true,
});

// افترض عندك معرف المستخدم
let userId = document.head.querySelector('meta[name="user-id"]').content;

Echo.private(`App.Models.User.${userId}`)
    .notification((notification) => {
        let n = toastr.info(
            `<a href="${notification.url}" style="color:white;text-decoration:underline;">
                ${notification.title}: ${notification.name}
             </a>`,
            '',
            {timeOut: 5000, closeButton: true, escapeHtml: false}
        );

        n.on('click', function() {
    // تعليم كمقروء عند الضغط
    fetch(`/notifications/read/${notification.id}`).then(() => {
        window.location.href = notification.url;
    });
});

    });
