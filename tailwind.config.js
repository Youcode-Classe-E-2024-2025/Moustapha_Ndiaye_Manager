/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "index.php",
    "./views/*.php",
    "./assets/js/*.js"
  ],
  theme: {
    extend: {
      colors: {
        // Personnalisez vos couleurs ici
        'primary': '#3490dc',
        'secondary': '#ffed4a',
      },
      spacing: {
        // Personnalisez vos espacements
        '128': '32rem',
      }
    },
  },
  plugins: [],
}