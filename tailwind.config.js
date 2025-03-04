import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'electric-orange': {
                    50: '#fff1e6',
                    100: '#ffe2cc',
                    200: '#ffc599',
                    300: '#ffa866',
                    400: '#ff8b33',
                    500: '#ff6f00', // Strong vibrant orange base
                    600: '#ff5500',
                    700: '#ff3d00',
                    800: '#ff2d00',
                    900: '#e62600',
                    950: '#cc1f00',
                },
            },
        },
    },

    plugins: [forms],
};
