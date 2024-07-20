const mix            = require('laravel-mix');
const public_path    = 'common/default';
const fs             = require('fs');

// Se está rodando no zend
const isZend = fs.existsSync('application');

mix.options({
	processCssUrls: false,
});

mix.webpackConfig({
	watchOptions: {
		ignored: /node_modules/
	}
});

// Pasta publica
mix.setPublicPath(public_path);

// Desabilita notificações
mix.disableNotifications();

const front_path = {
	source : 'assets/',
	css    : 'css/',
	js     : 'js/',
	fonts  : public_path + '/fonts/',
	img    : public_path + '/images/',
	uploads: 'common/uploads/',
};

// Sass
mix.sass(front_path.source + 'sass/app.scss', front_path.css + 'app.css');

// Js
mix.js([
	front_path.source + 'js/app.js',
], front_path.js + 'app.js');

// Copy font's folder
mix.copyDirectory(front_path.source + 'fonts/', front_path.fonts);

// Copy images's folder
mix.copyDirectory(front_path.source + 'images/', front_path.img);

if( !isZend )
{
	// Copy uploads's folder
	mix.copyDirectory(front_path.source + 'uploads/', front_path.uploads);
};

mix.browserSync({
	proxy: process.env.BROWSERSYNC_PROXY_URL,
	files: isZend ? [
		public_path + '/css/**/*.css',
		public_path + '/js/**/*.js',
		'application/layouts/default/**/*.tpl',
		'application/modules/default/controllers/*.php',
		'application/modules/default/views/**/*.tpl',
	] : [
		public_path + '/css/**/*.css',
		public_path + '/js/**/*.js',
		'include/*.php',
		'./*.php',
	]
});

if( mix.inProduction() )
{
	mix.version();
};