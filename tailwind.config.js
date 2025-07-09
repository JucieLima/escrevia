const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],
    theme: {
        extend: {
            fontFamily: {
                'playwrite-vn': ['"Playwrite Viet Nam Guides"', 'cursive', 'sans-serif'],
            },
            colors: {
                escreviaPrimary: '#E94E77',    // Rosa vibrante
                escreviaSecondary: '#051440',  // Azul marinho
                escreviaAccent: '#F27121',     // Laranja
                escreviaBgLight: '#FEF6F8',    // Rosa muito claro
                escreviaBorder: '#F3E5EA',     // Rosa dessaturado para bordas
                escreviaWhite: '#ffffff',       // Branco
                escreviaFeedback: '#485f9b',  // Azul

                // NOVAS CORES CLARAS PARA BACKGROUNDS
                'escreviaPrimary-light': '#FCDADE', // Tom muito claro do escreviaPrimary
                'escreviaAccent-light': '#FEE8D8',  // Tom muito claro do escreviaAccent
                'escreviaSecondary-light': '#d8ddff', // Tom muito claro do escreviaSecondary
                'green-light': '#D9F7DB',          // Tom muito claro para o verde
            },
        },
    },
    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography'),
    ],
};
