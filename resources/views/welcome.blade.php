<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Biblioteca de Artículos') }}</title>
@vite(['resources/css/app.css', 'resources/css/diseno.css', 'resources/js/app.js'])<!-- no le muevan aqui porfa ._. -->
</head>
<body>
    <div class="contenido">
        <h1 class="titulo">la biblioteca </h1>

    </div>

    <!-- Agregar cualquier script JS que sea necesario -->

</body>
</html>