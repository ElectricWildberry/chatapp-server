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

mix.js('resources/js/app.js', 'public/assets/js')
    // .postCss('resources/css/app.css', 'public/css', [
    //     require('tailwindcss'),
    //     require('autoprefixer'),
    // ])

    .js('resources/js/user/index.js', 'public/assets/js/user')
    .js('resources/js/admin/index.js', 'public/assets/js/admin')
    // .js('resources/js/user/JsBarcode.all.min.js', 'public/assets/js/user')

    .sass('resources/scss/user/style.scss', 'public/assets/css/user')
    .sass('resources/scss/admin/style.scss', 'public/assets/css/admin')
    .options({
        processCssUrls: false
    })

    .copyDirectory('resources/images', 'public/assets/images')
    // .copyDirectory('resources/js/user/ssi', 'public/assets/js/user/ssi')
    // .copyDirectory('resources/js/lib', 'public/assets/js/lib')
    ;

if (process.env.APP_ENV != 'local') {
    mix.version();
}