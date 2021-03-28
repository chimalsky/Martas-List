module.exports = {
  purge: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
  ],
  important: true,
    theme: {
      fontFamily: {
        'serif': ['"Cormorant Garamond"', 'Georgia', 'Cambria'],
        display: ['Gilroy', 'sans-serif'],
        body: ['Cormorant', 'sans-serif'],
      },
      extend: {
        colors: {
          cyan: '#9cdbff',
        },
        margin: {
          '96': '24rem',
          '128': '32rem',
        },
      }
    },
    variants: {
      opacity: ['responsive', 'hover']
    },
    plugins: [
      require('@tailwindcss/custom-forms'),
      require('tailwindcss-plugins/pagination')
    ]
}
