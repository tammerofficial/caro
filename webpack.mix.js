const mix = require('laravel-mix');

let theme = process.env.npm_config_theme;

if (theme) {
    require(`${__dirname}/themes/${theme}/webpack.mix.js`);
} else {
    // Default Mix configuration for the main project
    mix.js('resources/js/app.js', 'public/js')
       .sass('resources/sass/app.scss', 'public/css');
    
    // Auto-reload browser during development
    // mix.browserSync('localhost:8000');
    
    // Enable version hashing
    if (mix.inProduction()) {
        mix.version();
    }
}