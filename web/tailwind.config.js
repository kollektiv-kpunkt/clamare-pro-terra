/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './src/**/*.{html,js,svelte,ts,json}'
    ],
    theme: {
        extend: {
            colors: {
                "accent": "#F44813",
                "secondary": "#8DDC85",
                "foreground": "#2D3748"
            }
        },
    },
    plugins: [],
}

