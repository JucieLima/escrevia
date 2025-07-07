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
            colors: {
                escreviaPrimary: '#E94E77',    // Rosa vibrante
                escreviaSecondary: '#1D2C54',  // Azul marinho
                escreviaAccent: '#F27121',     // Laranja
                escreviaBgLight: '#FEF6F8',    // Rosa muito claro
                escreviaBorder: '#F3E5EA',     // Rosa dessaturado para bordas
                escreviaWhite: '#ffffff',       // Se você usou bg-white no guest.blade.php e não tem uma var, pode não precisar desta
            },
        },
    },
    plugins: [require('@tailwindcss/forms')],
};
