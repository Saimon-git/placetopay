const defaultTheme = require('tailwindcss/defaultTheme')

module.exports = {
  theme: {
    fontFamily: {
      roboto: ['Roboto', 'sans-serif'],
      sf: ['SF Pro Display', 'sans-serif'],
    },
    borderWidth: {
      default: '1px',
      '0': '0',
      '2': '2px',
      '4': '4px',
    },
    aspectRatio: {
      'none': 0,
      'square': [1, 1],
      '16/9': [16, 9],
      '4/3': [4, 3],
      '21/9': [21, 9],
    },
    extend: {
      colors: {
        cyan: '#9cdbff',
        green: '#8BC63E',
        orange: '#E9A41E',
        gray_body: '#ECECEC'
      },
      spacing: {
        '96': '24rem',
        '128': '32rem'
      },
      margin: {
          sm: '8px',
           md: '16px',
          lg: '24px',
          xl: '22rem',
    },
      maxHeight: {
        sm: '8px',
        md: '16px',
        lg: '24px',
        xl: '32rem',
      },
    },
  },
  variants: {},
  plugins: [
    require('@tailwindcss/custom-forms'),
    require('tailwindcss-aspect-ratio'),
  ]
};