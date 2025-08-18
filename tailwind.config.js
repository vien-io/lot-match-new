import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    prefix: 'tw-',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },
    variants: {
        extend: {
            textColor: ['group-hover'],
        },
    },
    safelist: [
    'tw-group-hover:tw-text-blue-500',
    'tw-group-hover:tw-text-green-500',
    'tw-group-hover:tw-text-yellow-500',
    'tw-group-hover:tw-text-purple-500',
    ],
    corePlugins: {
        collapse: false,
    },
    plugins: [],
};
