<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $articulo->titulo }}</title>

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
            max-width: 900px;
            margin: 40px auto;
        }

        .card {
            background: white;
            border-radius: 14px;
            padding: 30px;
            box-shadow: 0 8px 18px rgba(0, 0, 0, 0.08);
        }

        h1 {
            margin-top: 0;
            color: #111827;
        }

        .meta {
            color: #4b5563;
            margin-bottom: 14px;
        }

        .contenido {
            margin-top: 20px;
            line-height: 1.8;
            color: #1f2937;
            white-space: pre-line;
        }

        .acciones {
            margin-top: 30px;
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-block;
            text-decoration: none;
            padding: 10px 16px;
            border-radius: 8px;
            font-weight: bold;
        }

        .btn-volver {
            background: #6b7280;
            color: white;
        }

        .btn-abrir {
            background: #2563eb;
            color: white;
        }

        .sin-archivo {
            color: #b91c1c;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="contenedor">
        <div class="card">
            <h1>{{ $articulo->titulo }}</h1>

            <p class="meta">
                <strong>Autor:</strong> {{ $articulo->autor ?: 'No especificado' }}
            </p>

            <p class="meta">
                <strong>Fecha de registro:</strong>
                {{ $articulo->created_at ? $articulo->created_at->format('d/m/Y H:i') : 'Sin fecha' }}
            </p>

            <div class="contenido">
                {{ $articulo->resumen ?: 'Este artículo no tiene resumen registrado.' }}
            </div>

            <div class="acciones">
                <a href="{{ route('articulos.index') }}" class="btn btn-volver">Volver</a>

                @if ($articulo->archivo)
                    <a href="{{ asset('storage/' . $articulo->archivo) }}" target="_blank" class="btn btn-abrir">
                        Abrir archivo
                    </a>
                @else
                    <span class="sin-archivo">No hay archivo asociado.</span>
                @endif
            </div>
        </div>
    </div>
</body>
</html>