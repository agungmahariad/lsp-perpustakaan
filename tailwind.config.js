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

    // Safelist warna dinamis yang digunakan di dashboard dan about page
    safelist: [
        'bg-indigo-100', 'bg-purple-100', 'bg-blue-100', 'bg-green-100', 'bg-yellow-100', 'bg-red-100',
        'text-indigo-600', 'text-purple-600', 'text-blue-600', 'text-green-600', 'text-yellow-600', 'text-red-600',
    ],

    plugins: [forms],
};
