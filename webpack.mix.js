let mix = require('laravel-mix');

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
mix.options({
	processCssUrls: false,
});

//Public
mix.js('resources/assets/js/app.js', 'public/js');	//Archivos Vue
mix.sass('resources/assets/sass/app.scss', 'public/css');	//Codigo SASS
// mix.less('resources/assets/less/main.less', 'public/css');	// Codigo LESS

// //Dashboard (Panel de administracion)
mix.js('resources/assets/js/admin.js', 'public/js');	//Archivos Vue
//mix.sass('resources/assets/sass/admin.scss', 'public/css');	//Archivos SASS