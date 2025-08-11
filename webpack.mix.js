const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

// mix.js('resources/js/app.js', 'public/js').postCss('resources/css/app.css', 'public/css', []);

mix.js('resources/js/app.js', 'public/js');
mix.sass('resources/scss/app.scss', 'css/app.css');

mix.browserSync({
    open: 'external',
    host: 'acounting.local',
    proxy: 'acounting.local',
    port: 3000,
    files: ['resources/scss/*.scss', 'resources/js/*.js', 'resources/views/*.php', 'resources/views/*/*.php', 'resources/views/*/*/*.php', 'resources/views/*/*/*/*.php'],
    reloadDelay: 0
});

mix.disableSuccessNotifications();
