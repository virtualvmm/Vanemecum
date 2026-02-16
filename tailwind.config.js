const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    // Clases usadas dinámicamente desde modelos (TipoTratamiento, TipoPatogeno) para que Tailwind las genere
    safelist: [
        { pattern: /^(bg|text|border)-(red|blue|green|amber|yellow|gray)-(100|200|400|500|600|800|900)$/ },
        { pattern: /^border-l-4$/ },
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [require('@tailwindcss/forms')],
};
