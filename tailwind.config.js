module.exports = {
    mode: 'jit',
    content: [
        './lib/**/*.php',
        './pages/**/*.php',
        './fragments/**/*.php',
        './resources/**/*.js',
    ],  theme: {
        extend: {
            // colors: {
            //     primary: {
            //         DEFAULT: '#0D6EFD',
            //         '50': '#C3DBFF',
            //         '100': '#AFCFFE',
            //         '200': '#86B7FE',
            //         '300': '#5E9EFE',
            //         '400': '#3586FD',
            //         '500': '#0D6EFD',
            //         '600': '#0255D0',
            //         '700': '#013E99',
            //         '800': '#012861',
            //         '900': '#001129'
            //     },
            // },
        },
    },
    corePlugins: { // remove default styles
        preflight: false,
    },
    plugins: [
    ],
};
