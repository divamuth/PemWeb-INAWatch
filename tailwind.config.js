module.exports = {
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
  ],
  theme: {
    extend: {
      colors: {
        pastel: {
          blue: {
            100: '#e6efff',
            200: '#c5d7f9',
            300: '#a3bef6',
            400: '#91b5ca',
            500: '#7c9fb0',
            600: '#678996',
            700: '#54647f',
            800: '#415068',
            900: '#2f3b51',
            950: '#1c273a',
          },
          indigo: {
            100: '#ececff',
            200: '#c8c8fa',
            300: '#a3a4f6',
            400: '#97a4cb',
            500: '#828fb2',
            600: '#6d6a9a',
            700: '#585582',
            800: '#44426a',
            900: '#302f52',
            950: '#1c1d3a',
          },
          purple: {
            100: '#f3eaff',
            200: '#dfc6fa',
            300: '#cba3f6',
            400: '#be9fe4',
            500: '#a685c7',
            600: '#8d6caa',
            700: '#74538d',
            800: '#5a4070',
            900: '#412e53',
            950: '#281b36',
          },
          pink: {
            100: '#fff0fd',
            200: '#ffd8fb',
            300: '#ffb3f8',
            400: '#f89edf',
            500: '#e580c9',
            600: '#c26aaa',
            700: '#9f558b',
            800: '#7b406b',
            900: '#582b4c',
            950: '#35172c',
          },
          white: '#ffffff',
        },
      },
      backgroundImage: {
        'gradient-pastel': 'linear-gradient(135deg, #c5d7f9 0%, #dfc6fa 50%, #ffd8fb 100%)',
      }
    },
  },
  plugins: [],
}