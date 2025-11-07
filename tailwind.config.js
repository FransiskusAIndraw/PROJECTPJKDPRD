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
        },
    },

    safelist: [
    'bg-red-800','bg-red-900','hover:bg-red-700','border-red-700',
    'bg-blue-800','bg-blue-900','hover:bg-blue-700','border-blue-700',
    'bg-green-800','bg-green-900','hover:bg-green-700','border-green-700',
    'bg-gray-800','bg-gray-900','hover:bg-gray-700','border-gray-700',
  ],

    plugins: [forms],
};
