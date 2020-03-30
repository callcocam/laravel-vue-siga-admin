const mix = require('laravel-mix');
require('laravel-mix-vue-auto-routing');
mix
    .webpackConfig({
        resolve: {
            alias: {
                '@': path.resolve(__dirname, 'resources/js/vendor/src'),
                '@assets': path.resolve(__dirname, 'resources/vendor/assets'),
                '@sass': path.resolve(__dirname, 'resources/vendor/sass')
            }
        },
        output: {
            chunkFilename: 'js/[name].[chunkhash].js',
        }
    }).js('resources/js/vendor/app.js', 'public/js')
    .sass('resources/vendor/sass/app.scss', 'public/css')
    .vueAutoRouting({
        pages: 'resources/js/vendor/src/pages',
        chunkNamePrefix: 'page-'
    });
