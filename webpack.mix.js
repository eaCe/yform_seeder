const mix = require('laravel-mix');

mix.webpackConfig({
    optimization: {
        providedExports: false,
        sideEffects: false,
        usedExports: false
    }
});

mix.js('./resources/js/yform-seeder.js', 'assets')
    .postCss('resources/styles/yform-seeder.css', 'assets',
        [
            require('tailwindcss'),
        ]);

mix.disableNotifications();
mix.sourceMaps(false, 'source-map');
