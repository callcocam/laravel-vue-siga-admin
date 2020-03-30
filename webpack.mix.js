const mix = require('laravel-mix');


require('laravel-mix-vue-auto-routing');
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

mix
.webpackConfig({
    resolve: {
        alias: {
            '@': path.resolve(__dirname, 'resources/js/src'),
            '@assets': path.resolve(__dirname, 'resources/assets'),
            '@sass': path.resolve(__dirname, 'resources/sass')
        }
    },
    output: {
        chunkFilename: 'js/[name].[chunkhash].js',
    }
}).js('resources/js/app.js', 'public/js')
   .sass('resources/sass/app.scss', 'public/css')
   .vueAutoRouting({
    pages: 'resources/js/src/pages',
    chunkNamePrefix: 'page-'
   });
