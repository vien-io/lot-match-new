import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/js/app.js',
                'resources/js/dashboardMap.js',
                'resources/js/settings.js',
                'resources/js/reviews.js',
                'resources/js/smoothSticky.js',
                'resources/js/charts/forecast.js',
                'resources/js/properties.js',
                'resources/js/userModals.js',
                'resources/js/activity_logs/activityLogs.js',
                'resources/js/signup.js',
                'resources/css/app.css',
                'resources/sass/app.scss',
            ],
            refresh: true,
        }),
    ],
});
