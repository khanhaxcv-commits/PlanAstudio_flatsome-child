/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./**/*.php", "./assets/js/**/*.js"],
  theme: {
    extend: {
      fontFamily: {
        hanken: ['"Hanken Grotesk"', "sans-serif"],
      },
    },
  },
  plugins: [],
};
