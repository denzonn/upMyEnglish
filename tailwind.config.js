import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: "#00BCD4",
                secondary: "#B2EBF2",
                third: "#00838F",
                backPrimary: "#b2ebf26b",
            },
            rotate: {
                "-8": "-8deg",
                "-10": "-10deg",
            },
        },
    },

    plugins: [forms],
};
