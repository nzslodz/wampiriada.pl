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

mix.js('resources/assets/js/app.js', 'js')
   .js('resources/assets/js/main.js', 'js')
   .js('resources/assets/js/checkin.js', 'js')
   .sass('resources/assets/sass/main.scss', 'css')
   .sass('resources/assets/sass/checkin.scss', 'css')
   .sass('resources/assets/sass/app.scss', 'css')

if (isProduction) {
    mix.version();
}
