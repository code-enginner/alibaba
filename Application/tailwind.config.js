/** @type {import('tailwindcss').Config} */
// import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        "./src/**/*.{html,js}",
        "./node_modules/tw-elements/js/**/*.js"
    ],

    theme: {
        extend: {
            // fontFamily: {
            //     sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            // },
        },
    },

    plugins: [require("tw-elements/plugin.cjs")],

    darkMode: "class"
};
