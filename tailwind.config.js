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

            colors: {
                'sidebar-green': '#22c55e',
                'sidebar-gray': '#6b7280',
            },

            keyframes: {
                pulseColor: {
                    '0%, 100%': { color: '#6b7280' }, 
                    '50%': { color: '#22c55e' },       
                },
                pulseToGreen: {
                    '0%, 69%': { color: '#9ca3af'},
                    '70%': {color: '#22c55e'},
                    '87%, 100%': { color: '#9ca3af'},
                },
            },

            animation: {
                'pulse-color': 'pulseColor 2s infinite',
                'pulse-to-green': 'pulseToGreen 5s ease-in-out infinite',
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