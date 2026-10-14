import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            colors: {
                'hijau-daun': '#2F6B4F',
                'krem': '#FAF7F0',
                'cokelat-tanah': '#9C6B3E',
                'abu-gelap': '#2B2B2B',
            },
            fontFamily: {
                poppins: ['Poppins', ...defaultTheme.fontFamily.sans],
                inter: ['Inter', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [],
};