import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './node_modules/flowbite/*/.js',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            animation: {
                fadeIn: 'fadeIn 2s ease-in-out',
            },
            keyframes: {
                fadeIn: {
                '0%': { opacity: '0' },
                '100%': { opacity: '1' },
                },
            },
        },
    },

    plugins: [
        forms,
        require('flowbite/plugin')
    ],

    extend: {
        animation: {
            fadeIn: 'fadeIn 2s ease-in-out',
        },
        keyframes: {
            fadeIn: {
            '0%': { opacity: 0 },
            '100%': { opacity: 1 },
            },
        },
    }

};
