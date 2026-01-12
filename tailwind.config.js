/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        'salon-pink': '#FFB6C1',
        'salon-cream': '#FFF8DC',
        'salon-rose': '#FF69B4',
        'salon-purple': '#DDA0DD',
      },
      fontFamily: {
        'sans': ['Poppins', 'sans-serif'],
      },
    },
  },
  plugins: [],
}

