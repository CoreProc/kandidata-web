var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function (mix) {
    mix
        .copy('resources/assets/js/services', 'public/assets/js/services')
        .copy('resources/assets/js/factories', 'public/assets/js/factories')
        .copy('resources/assets/js/controllers', 'public/assets/js/controllers')
        .scripts([
            'app.config.js',
            'app.routes.js'
        ], 'public/assets/js/app.js')
        .sass(['animation.scss','addon.scss'], 'public/assets/css/addon.css')
        .sass('main.scss', 'public/assets/css/main.css');
});
