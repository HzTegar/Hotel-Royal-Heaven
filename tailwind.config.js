/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/views/**/*.blade.php",
        "./resources/js/**/*.js",
        "./resources/js/**/*.vue",
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: [
                    "Instrument Sans",
                    "ui-sans-serif",
                    "system-ui",
                    "sans-serif",
                    "Apple Color Emoji",
                    "Segoe UI Emoji",
                    "Segoe UI Symbol",
                    "Noto Color Emoji",
                ],
            },
            colors: {
                gold: {
                    50: "#FDF8E6",
                    100: "#FBF0CD",
                    200: "#F7E19B",
                    300: "#F3D169",
                    400: "#EFC237",
                    500: "#E3A008", // Primary Gold
                    600: "#B68006",
                    700: "#886005",
                    800: "#5B4003",
                    900: "#2D2002",
                },
            },
        },
    },
    plugins: [],
};
