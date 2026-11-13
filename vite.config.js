import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/js/app.js",
                "resources/js/pages/dashboard/dashboardMap.js",
                "resources/js/settings.js",
                "resources/js/reviews.js",
                "resources/js/smoothSticky.js",
                "resources/js/charts/forecast.js",
                "resources/js/pages/properties/properties.js",
                "resources/js/pages/properties/property-gallery.js",
                "resources/js/pages/properties/property-filters.js",
                "resources/js/activity_logs/activityLogs.js",
                "resources/js/pages/sign-in/autofill.js",
                "resources/js/signup.js",
                "resources/css/app.css",
                "resources/sass/app.scss",
                "resources/css/print.css",
            ],
            refresh: true,
        }),
    ],
});
