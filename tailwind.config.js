/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./index.html",
    "./login.html",
    "./dashboard.html",
    "./profile.html",
    "./user_management.html",
    "./approval_list.html",
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