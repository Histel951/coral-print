const mix = require('laravel-mix');
const path = require('path');

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

mix.copyDirectory('./node_modules/ckeditor4', 'public/js/ckeditor4')
    .js('resources/js/app.js', 'public/js')
    .js('resources/js/dashboard.js', 'public/js')
    .sourceMaps()
    .postCss('resources/css/app.css', 'public/css')
    .postCss('resources/css/platform.css', 'public/css');

mix.js('resources/js/vue/main.js', 'public/js/vue')
    .vue({version: 3})
    .alias({
        '@': path.resolve(__dirname, 'resources/js/vue')
    })
    .options({
        vue: {
            presets: [
                '@vue/cli-plugin-babel/preset'
            ]
        }
    });
