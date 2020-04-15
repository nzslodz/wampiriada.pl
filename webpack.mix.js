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

 var isProduction = mix.inProduction()

 mix.setPublicPath(isProduction ? 'public/dist' : 'public/local');
 mix.setResourceRoot(isProduction ? '/dist/' : '/local/');

mix.js('resources/js/app.js', 'js')
   .js('resources/js/main.js', 'js')
   .js('resources/js/checkin.js', 'js')
   .sass('resources/sass/main.scss', 'css')
   .sass('resources/sass/checkin.scss', 'css')
   .sass('resources/sass/app.scss', 'css')

if (isProduction) {
    mix.version();
}
