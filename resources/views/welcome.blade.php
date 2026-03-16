<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ config('app.name', 'Biblioteca de Artículos') }}</title>

@vite(['resources/css/app.css', 'resources/css/diseno.css', 'resources/js/app.js']) <!-- no le muevan aqui porfa ._. -->

<style>

body{
background-color:#24323d;
color:white;
font-family: Arial, Helvetica, sans-serif;
margin:0;
padding:0;
}

.contenido{
display:flex;
justify-content:center;
align-items:center;
min-height:100vh;
}

.card{
background:#2f3e4a;
padding:40px;
border-radius:10px;
width:400px;
text-align:center;
box-shadow:0px 5px 15px rgba(0,0,0,0.3);
}

.titulo{
font-size:32px;
margin-bottom:25px;
}

.estrellas button{
background:none;
border:none;
font-size:40px;
cursor:pointer;
transition:0.2s;
}

.estrellas button:hover{
transform:scale(1.3);
}

</style>

</head>

<body>

<div class="contenido">

<div class="card">

<h1 class="titulo">la biblioteca</h1>

<!-- TU MODULO DE CALIFICACIONES -->

<form method="POST" action="{{ route('rate.article') }}">
@csrf

<input type="hidden" name="article_id" value="1">

<label>Califica este artículo:</label><br>

<div class="estrellas">
<button type="submit" name="rating" value="1">⭐</button>
<button type="submit" name="rating" value="2">⭐</button>
<button type="submit" name="rating" value="3">⭐</button>
<button type="submit" name="rating" value="4">⭐</button>
<button type="submit" name="rating" value="5">⭐</button>
</div>

</form>

<!-- PROMEDIO DE CALIFICACIONES -->

@php
use App\Models\Rating;

$promedio = round(Rating::where('article_id',1)->avg('rating'),1);
$total = Rating::where('article_id',1)->count();
@endphp

<div style="margin-top:20px; font-size:20px;">

<strong>Promedio:</strong>

@for ($i = 1; $i <= 5; $i++)
@if ($promedio >= $i)
⭐
@else
☆
@endif
@endfor

<span> {{ $promedio ?? 0 }} / 5 </span>

<br>

<small>{{ $total }} calificaciones</small>

</div>

</div>

</div>

</body>
</html>