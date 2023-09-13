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
 mix.styles([ 'resources/assets/css/bootstrap.min.css',
'resources/assets/css/main.css',
'resources/assets/css/mediaq.css',
'resources/assets/css/framework7.bundle.min.css'], './resources/assets/css/front.css');
// mix.js('resources/js/app.js', 'public/js')
//     .postCss('resources/css/app.css', 'public/css', [
//         //
//     ]);
