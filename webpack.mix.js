let mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/assets/js/app.js', 'public/js')
   .sass('resources/assets/sass/app.scss', 'public/css');

mix.js('resources/assets/js/appjq.js', 'public/js')

mix.copy('resources/assets/js/m/appmobile.js', 'public/js/m');
mix.sass('resources/assets/sass/m/appmobile.scss', 'public/css/m');

/*mix.minify('resources/assets/js/m/appmobile.js')
    .copy('resources/assets/js/m/appmobile.min.js', 'public/js/m');*/
   
/*mix.copy('resources/assets/js/m/appmobile.js', 'public/js/m');*/


