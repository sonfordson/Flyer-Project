var elixir = require('laravel-elixir');



elixir(function(mix) {
 mix.sass('app.scss')
     .scripts([

      'libs/sweetalert-dev.js',
         'libs/lity.js'
     ],'./public/js/libs.js')

     .styles([

      'libs/sweetalert.css',
         'libs/lity.css'
     ],'./public/css/libs.css');
});
