let mix = require('laravel-mix');

require('dotenv').config();

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
   .stylus('resources/assets/stylus/main.styl', 'public/css/vuetify.css')
   .sass('resources/assets/sass/app.scss', 'public/css')
   .copy('node_modules/mdi/css/materialdesignicons.min.css', 'public/css')
   .copy('node_modules/mdi/fonts/*', 'public/fonts')
   .copy('resources/assets/images', 'public/images');
