import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/js/app.js",
                "resources/js/pages/dashboard/dashboard.js",
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
                "resources/js/pages/analytics/block-ratings-chart.js",
                "resources/js/signup.js",
                "resources/js/pages/owner-verification/select-lot.js",
                "resources/css/app.css",
                "resources/css/print.css",
                "resources/css/pages/user-management/user-management.css",
                "resources/css/sidebar.css",
                "resources/css/components/full-report.css",
                "resources/css/notification.css",
                "resources/css/header.css",
                "resources/css/components/forecast-loading.css",
                "resources/css/pages/analytics/analytics.css",
                "resources/css/pages/forecasting.css",
                "resources/css/dashboard.css",
                "resources/sass/app.scss",
            ],
            refresh: true,
        }),
    ],
});
