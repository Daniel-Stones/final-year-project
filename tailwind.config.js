import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './resources/views/**/*.blade.php',  
      ],
    safelist: [
        'input-field', 
    ],
    theme: {
        extend: {
            colors: {
                'default-green': '#238955',
                'default-grey': '#D1D1D1'
            }
        },
    },
    plugins: [],
};
