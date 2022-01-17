const mix = require('laravel-mix');
const tailwindcss = require('tailwindcss')

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

mix.webpackConfig({
  resolve: {
      alias: {
          '@lib': path.resolve(__dirname, 'resources/js/project/lib'),
          '@helpers': path.resolve(__dirname, 'resources/js/project/helpers')
      }
  }      
});

mix.js('resources/js/app.js', 'public/js')
  .less('resources/less/app.less', 'public/css')
    .options({
      postCss: [
        tailwindcss('./tailwind.config.js'),
      ]
    })
  .version(); 

mix.js('resources/js/project/app.js', 'public/js/project')
    .version();
mix.js('resources/js/project/birdring.js', 'public/js/project')
	.version();