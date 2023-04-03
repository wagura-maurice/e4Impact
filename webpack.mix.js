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

mix.sass("resources/scss/app.scss", "public/css/main")
    .sass("resources/scss/themes/dark/app-dark.scss", "public/css/main")
    .sass("resources/scss/pages/auth.scss", "public/css/pages")
    .sass("resources/scss/pages/chat.scss", "public/css/pages")
    .sass("resources/scss/pages/datatables.scss", "public/css/pages")
    .sass("resources/scss/pages/dripicons.scss", "public/css/pages")
    .sass("resources/scss/pages/email.scss", "public/css/pages")
    .sass("resources/scss/pages/error.scss", "public/css/pages")
    .sass("resources/scss/pages/form-element-select.scss", "public/css/pages")
    .sass("resources/scss/pages/simple-datatables.scss", "public/css/pages")
    .sass("resources/scss/pages/summernote.scss", "public/css/pages")
    .sass("resources/scss/widgets/chat.scss", "public/css/widgets")
    .sass("resources/scss/widgets/todo.scss", "public/css/widgets")
    .sass("resources/scss/iconly.scss", "public/css/shared")
    .js("resources/js/app.js", "public/js")
    