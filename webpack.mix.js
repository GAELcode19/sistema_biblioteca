const mix = require('laravel-mix');

// Compila y copia el archivo CSS de 'resources/css/diseño.css' a 'public/css'
mix.postCss('resources/css/diseño.css', 'public/css');