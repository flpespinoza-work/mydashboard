const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    purge: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'gray-25': '#fefefe',
                'gray-135': '#f0f2f4',
                'gray-150': '#F0F1F3',
                'orange': '#ef6a37',
                'orange-light': '#ffe6dd',
                'orange-lightest': '#FEF8F3'
            },
            fontSize: {
                'xxs': '.65rem'
            }
        },
    },

    variants: {
        extend: {
            opacity: ['disabled'],
        },
    },

    plugins: [require('@tailwindcss/forms')],
};
