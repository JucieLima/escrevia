const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
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
                escreviaWhite: '#ffffff',      // Branco

                // Cores auxiliares ajustadas
                escreviaBgLight: '#FFF5F7',           // Rosa claro mais limpo e neutro, com melhor contraste
                escreviaBorder: '#F2E6EA',            // Suavizado para harmonizar com BgLight
                escreviaFeedback: '#3DC4D6',          // Azul profundo e limpo

                // Novas cores claras (harmonizadas com as principais)
                'escreviaPrimary-light': '#FAD4DC',     // Suavização do rosa principal
                'escreviaAccent-light': '#FFE3C8',      // Laranja mais suave com fundo pastel
                'escreviaSecondary-light': '#E1E7FF',   // Azul claro coerente com o marinho
                'green-light': '#D0F2D5',               // Verde mais suave e "fresh", fugindo do tom neon
            },
        },
    },

    plugins: [require('@tailwindcss/forms')],
};
