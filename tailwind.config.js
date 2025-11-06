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
                sans: ['"Poppins"', 'Helvetica', 'Arial', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                brand: {
                    black: '#111111',
                    white: '#FFFFFF',
                    gray: '#F5F5F5',
                    darkGray: '#1F1F1F',
                },
            },
        },
    },

    plugins: [forms],
};
