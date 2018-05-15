var elixir = require('laravel-elixir');

require('laravel-elixir-vue-2');


paths = {}

if(elixir.config.production) {
    paths = {
        sass: 'public/dist/css',
        webpack: 'public/dist/js',
    };
}

elixir(function(mix) {
    mix.sass('app.scss', paths.sass)
       .webpack('app.js', paths.webpack);
});
