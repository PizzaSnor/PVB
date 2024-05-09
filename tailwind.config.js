import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],
    theme: {
        extend: {
            fontFamily: { // deze is dus nog de oude font family, die moet nog aangepast worden
                sans: ['Tw Cen MT Std', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                yellow: "#E8C700",
            },
            fontSize: {
                'heading1': ['96px', '115px'],
                'heading2': ['60px', '72px'],
                'heading3': ['48px', '58px'],
                'heading4': ['34px', '41px'],
                'heading5': ['24px', '29px'],
                'heading6': ['20px', '24px'],
                'paragraphL': ['24px', '29px'],
                'paragraphM': ['20px', '24px'],
                'paragraphS': ['16px', '19px'],
                'button': ['20px', '24px'],
                'caption': ['14px', '17px'],
                'text': ['24px', '32px'],
            },
        },
    },

    plugins: [forms],
};
