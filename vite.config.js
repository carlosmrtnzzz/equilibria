import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/cambiar-platos.js',
                'resources/js/chat-equilibria.js',
                'resources/js/home-scroll-animation.js',
                'resources/js/modal-handler.js',
                'resources/js/preferencias.js',
                'resources/js/toast-notification.js',
            ], refresh: true,
        }),
        tailwindcss(),
    ],
});
