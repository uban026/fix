import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
        './node_modules/flowbite/**/*.js'  // Tambahkan ini
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                yellow: {
                    50:  '#fffbea',
                    100: '#fff3c4',
                    200: '#fce588',
                    300: '#fadb5f',
                    400: '#f7c948',
                    500: '#f0b429', // <- ini bisa kamu ubah dengan RGB lain
                    600: '#de911d',
                    700: '#cb6e17',
                    800: '#b44d12',
                    900: '#8d2b0b'
                }
            }
        },
    },
    plugins: [
        require('flowbite/plugin'),
        require('@tailwindcss/forms')
    ],
};
