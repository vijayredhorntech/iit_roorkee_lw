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
                primary: '#001A6E',
                secondary: '#074799',
                primaryLight: '#E1FFBB',
                secondaryLight: '#009990',

                white: '#FFFFFF',
                black: '#000000',
                danger: '#FF0000',
                success: '#28a745',
                warning: '#FFA500',
            },
        },
    },

    plugins: [forms],
};
