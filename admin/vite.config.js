import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.scss',
                'resources/js/app.js',
                "resources/css/testimonial/style.scss"
            ],
            refresh: true,
        }),
    ],
    server: {
        hmr: {
            host: 'cpt-admin.ddev.site',
            protocol: "wss"
        }
    }
});
