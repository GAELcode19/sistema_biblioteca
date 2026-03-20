<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca Interactiva</title>
    @vite(['resources/css/app.css', 'resources/css/diseno.css', 'resources/js/app.js'])

</head>

<body>

    <div class="contenedor-busqueda">
<form action="{{ route('home') }}" method="GET" style="display: flex; align-items: center; background-color: #2a3441; border-radius: 20px; padding: 5px 15px;">
    <input type="text" name="buscar" placeholder="buscar libros..." value="{{ request('buscar') }}" style="background: transparent; border: none; color: white; outline: none; width: 200px;">
    <button type="submit" style="background: none; border: none; cursor: pointer; color: #888;">
        🔍
    </button>
</form>
        
        <button id="btn-activar-pdf" class="boton_subir_pdf">
            📄 Subir PDF
        </button>
        <input type="file" id="input-subir-pdf" accept="application/pdf" style="display: none;">

        <button id="btn-subir-nuevo" class="boton_subir">Subir Nuevo</button>
    </div>

<div class="contenido" id="contenedor-cartas">
    @foreach($articulos as $articulo)
    <article class="card">
        <div class="formulario-resena" style="padding: 20px; display: flex; flex-direction: column; min-height: 400px;">
            <div class="card-header-internal">
                <div>
                    <h2 class="card-title-text" style="font-size: 1.2rem; color: #333;">{{ $articulo->titulo }}</h2>
                    <p class="card-author-text">Por: {{ $articulo->autor }}</p>
                    @if($articulo->archivo_pdf)
    <div style="margin-top: 10px; margin-bottom: 15px;">
        <a href="{{ asset('storage/' . $articulo->archivo_pdf) }}" target="_blank" style="background-color: #dc3545; color: white; padding: 6px 12px; border-radius: 5px; text-decoration: none; font-size: 0.85rem; font-weight: bold; display: inline-block;">
            📄 Leer PDF
        </a>
    </div>
@endif
                </div>
                <span class="badge">NUEVO</span>
            </div>
            
            <div class="contenedor-resenas-locales">
                @if($articulo->resenas->isEmpty())
                    <p class="sin-resenas" style="font-size: 0.8rem; color: #aaa; text-align: center;">Aún no hay reseñas.</p>
                @else
                    @foreach($articulo->resenas as $resena)
                        <div class="resena-item">
<div class="resena-header">
    <strong>Usuario</strong>
    <span>
        {{ str_repeat('⭐', $resena->puntuacion) }} {{ $resena->created_at->format('H:i') }}
    </span>
</div>
                            <div>{{ $resena->comentario }}</div>
                        </div>
                    @endforeach
                @endif
            </div>
<div class="seccion-input" style="margin-top: auto;">
    <form action="{{ route('resenas.store') }}" method="POST">
        @csrf
        <input type="hidden" name="articulo_id" value="{{ $articulo->id }}">
        
        <div class="rating-container" style="margin-bottom: 10px;">
            <span class="rating-text" style="font-size: 0.9rem; margin-bottom: 5px; display: block;">Tu calificación:</span>
            <div class="rating">
                <input value="5" name="puntuacion" id="star5_{{ $articulo->id }}" type="radio" required>
                <label title="5 estrellas" for="star5_{{ $articulo->id }}"></label>
                
                <input value="4" name="puntuacion" id="star4_{{ $articulo->id }}" type="radio">
                <label title="4 estrellas" for="star4_{{ $articulo->id }}"></label>
                
                <input value="3" name="puntuacion" id="star3_{{ $articulo->id }}" type="radio">
                <label title="3 estrellas" for="star3_{{ $articulo->id }}"></label>
                
                <input value="2" name="puntuacion" id="star2_{{ $articulo->id }}" type="radio">
                <label title="2 estrellas" for="star2_{{ $articulo->id }}"></label>
                
                <input value="1" name="puntuacion" id="star1_{{ $articulo->id }}" type="radio">
                <label title="1 estrella" for="star1_{{ $articulo->id }}"></label>
            </div>
        </div>

        <textarea name="comentario" class="input-opinion" rows="2" placeholder="Escribe tu comentario..." style="width:100%; border:1px solid #ddd; border-radius:8px; padding:10px; font-size: 0.9rem; resize: none;" required></textarea>
        <button type="submit" class="boton_subir btn-enviar-resena" style="margin-top:8px; width:100%; padding: 10px;">Publicar Comentario</button>
    </form>
</div>

            <footer class="card-footer" style="margin-top:15px; display:flex; justify-content:flex-end; gap:10px; border-top: 1px solid #eee; padding-top: 10px;">
                <button type="button" class="icon-btn Boton_editar btn-editar" data-id="{{ $articulo->id }}" data-titulo="{{ $articulo->titulo }}" data-autor="{{ $articulo->autor }}">✏️</button>
                
                
                <form action="{{ route('articulos.destroy', $articulo->id) }}" method="POST" onsubmit="return confirm('¿Eliminar esta tarjeta y todas sus reseñas de la base de datos?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="icon-btn delete-btn Boton_eliminar" style="border:none; background:none; cursor:pointer;">🗑️</button>
                </form>
            </footer>
        </div>
    </article>
    @endforeach
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Elementos del DOM
        const btnSubir = document.getElementById('btn-subir-nuevo');
        const btnActivarPdf = document.getElementById('btn-activar-pdf');
        const inputPdf = document.getElementById('input-subir-pdf');

        // --- 1. Lógica del Botón de PDF (Visual) ---
        // Al hacer clic en el botón rojo "Subir PDF", abrimos la ventana oculta de archivos
        btnActivarPdf.addEventListener('click', function(e) {
            e.preventDefault();
            inputPdf.click();
        });

        // Cambiamos el texto del botón temporalmente para saber que sí se cargó un archivo en la memoria
        inputPdf.addEventListener('change', function() {
            if(this.files.length > 0) {
                btnActivarPdf.innerHTML = "✔️ PDF Listo"; // Cambia el texto
                btnActivarPdf.style.backgroundColor = "#28a745"; // Se pone verde para confirmar
                btnActivarPdf.style.borderColor = "#28a745";
            } else {
                // Si el usuario abre la ventana pero le da a "Cancelar"
                btnActivarPdf.innerHTML = "📄 Subir PDF"; 
                btnActivarPdf.style.backgroundColor = ""; 
                btnActivarPdf.style.borderColor = "";
            }
        });

        // --- 2. Lógica del Botón "Subir Nuevo" (Enviar datos a Laravel) ---
        btnSubir.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Pedimos los datos al usuario
            let titulo = prompt("Título del libro:");
            if (!titulo) return; // Si cancela, detenemos todo
            
            let autor = prompt("Autor del libro:");
            if (!autor) return;

            // Empaquetamos los datos y el archivo (FormData es el formato obligatorio para enviar archivos)
            let formData = new FormData();
            formData.append('_token', '{{ csrf_token() }}'); // Pase VIP de seguridad de Laravel
            formData.append('titulo', titulo);
            formData.append('autor', autor);

            // Si seleccionaron un archivo en el input oculto, lo metemos al paquete
            if (inputPdf.files.length > 0) {
                formData.append('archivo_pdf', inputPdf.files[0]);
            }

            // Cambiamos el texto del botón para que el usuario sepa que está cargando
            let textoOriginal = btnSubir.innerHTML;
            btnSubir.innerHTML = "Subiendo...";
            btnSubir.disabled = true;

            // Enviamos el paquete a la ruta de Laravel
            fetch('{{ route("articulos.store") }}', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (response.ok) {
                    // Cuando termine y todo salga bien, recargamos la página para ver la tarjeta nueva
                    window.location.reload(); 
                } else {
                    alert("Hubo un error al guardar el libro en el servidor.");
                    btnSubir.innerHTML = textoOriginal;
                    btnSubir.disabled = false;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert("Error de conexión.");
                btnSubir.innerHTML = textoOriginal;
                btnSubir.disabled = false;
            });
        });
        // --- 3. Lógica del Botón "Editar" ---
        const botonesEditar = document.querySelectorAll('.btn-editar');

        botonesEditar.forEach(boton => {
            boton.addEventListener('click', function(e) {
                e.preventDefault();

                // 1. Obtenemos los datos actuales que escondimos en el botón
                let id = this.getAttribute('data-id');
                let tituloActual = this.getAttribute('data-titulo');
                let autorActual = this.getAttribute('data-autor');

                // 2. Le preguntamos al usuario los nuevos datos (mostrando los actuales por defecto)
                let nuevoTitulo = prompt("Editar Título:", tituloActual);
                if (nuevoTitulo === null) return; // Si le da a "Cancelar", detenemos todo

                let nuevoAutor = prompt("Editar Autor:", autorActual);
                if (nuevoAutor === null) return;

                // 3. Empaquetamos los datos
                let formData = new FormData();
                formData.append('_token', '{{ csrf_token() }}');
                formData.append('_method', 'PUT'); // Truco de Laravel para simular una petición PUT
                formData.append('titulo', nuevoTitulo);
                formData.append('autor', nuevoAutor);

                // 4. Enviamos la orden al servidor
                fetch(`/editar-articulo/${id}`, {
                    method: 'POST', // Usamos POST pero con el _method=PUT empaquetado
                    body: formData
                })
                .then(response => {
                    if (response.ok) {
                        // Si todo sale bien, recargamos la página para ver los cambios
                        window.location.reload();
                    } else {
                        alert("Hubo un error al editar el libro.");
                    }
                })
                .catch(error => console.error('Error:', error));
            });
        });
    });
</script>
</body>
</html>