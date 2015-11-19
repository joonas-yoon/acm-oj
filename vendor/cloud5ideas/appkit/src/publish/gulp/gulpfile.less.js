var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Less
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    mix.less(['app.less', 'appkit.less']).coffee();

    mix.styles([
        "app.css",
        "appkit.css"
    ], null, 'public/css');

    mix.version(['public/css/all.css', 'public/js/appkit.js']);
});
