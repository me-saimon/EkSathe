/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Foundation/Console/Resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],
    theme: {
        extend: {
            colors: {
                "primary": "#006c49",
                "primary-container": "#10b981",
                "on-primary-container": "#00422b",
                "secondary": "#515f74",
                "background": "#f7f9fb",
                "surface-container-lowest": "#ffffff",
                "on-surface": "#191c1e",
                "outline-variant": "#bbcabf",
                "tertiary-container": "#e29100",
            },
            fontFamily: {
                manrope: ['Manrope', 'sans-serif'],
                inter: ['Inter', 'sans-serif'],
            },
        },
    },
    plugins: [require('@tailwindcss/forms')],
};
