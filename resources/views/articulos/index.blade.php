<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca de Artículos</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 0;
        }

        .contenedor {
            width: 90%;
            max-width: 1100px;
            margin: 40px auto;
        }

        .encabezado {
            text-align: center;
            margin-bottom: 30px;
        }

        .encabezado h1 {
            margin: 0;
            color: #1f2937;
        }

        .encabezado p {
            color: #6b7280;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
        }

        .card {
            background: #fff;
            border-radius: 14px;
            padding: 20px;
            box-shadow: 0 8px 18px rgba(0, 0, 0, 0.08);
        }

        .card h2 {
            margin-top: 0;
            color: #111827;
            font-size: 22px;
        }

        .meta {
            color: #4b5563;
            margin-bottom: 12px;
        }

        .resumen {
            color: #374151;
            margin-bottom: 18px;
            line-height: 1.6;
        }

        .btn {
            display: inline-block;
            background: #2563eb;
            color: white;
            text-decoration: none;
            padding: 10px 16px;
            border-radius: 8px;
            font-weight: bold;
        }

        .sin-registros {
            background: white;
            padding: 30px;
            text-align: center;
            border-radius: 14px;
            box-shadow: 0 8px 18px rgba(0, 0, 0, 0.08);
        }
    </style>
</head>
<body>
    <div class="contenedor">
        <div class="encabezado">
            <h1>Biblioteca de Artículos</h1>
            <p>Consulta los artículos disponibles</p>
        </div>

        @if ($articulos->isEmpty())
            <div class="sin-registros">
                <h2>No hay artículos registrados</h2>
                <p>Agrega registros en la base de datos para comenzar a probar el módulo de lectura.</p>
            </div>
        @else
            <div class="grid">
                @foreach ($articulos as $articulo)
                    <div class="card">
                        <h2>{{ $articulo->titulo }}</h2>

                        <p class="meta">
                            <strong>Autor:</strong>
                            {{ $articulo->autor ?: 'No especificado' }}
                        </p>

                        <p class="resumen">
                            {{ \Illuminate\Support\Str::limit($articulo->resumen, 120, '...') }}
                        </p>

                        <a href="{{ route('articulos.show', $articulo->id) }}" class="btn">
                            Leer
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</body>
</html>