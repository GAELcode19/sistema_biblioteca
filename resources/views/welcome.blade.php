<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca Interactiva</title>
    @vite(['resources/css/app.css', 'resources/css/diseno.css', 'resources/js/app.js'])
    <style>
        .contenido { display: flex; flex-wrap: wrap; gap: 30px; justify-content: center; padding: 120px 20px; min-height: 100vh; }
        .contenedor-busqueda { position: fixed; top: 0; right: 0; left: 0; background: #1b262f; padding: 15px 30px; display: flex; justify-content: flex-end; align-items: center; z-index: 1000; box-shadow: 0 4px 10px rgba(0,0,0,0.3); }
        
        .contenedor-resenas-locales {
            max-height: 200px; 
            overflow-y: auto;
            margin: 15px 0;
            padding-right: 8px;
            display: flex;
            flex-direction: column;
            gap: 8px; 
        }

        .resena-item {
            background: #f8f9fa;
            border-left: 4px solid #c17b11;
            padding: 10px;
            border-radius: 6px;
            font-size: 0.85rem;
            color: #444;
            box-shadow: 0 2px 4px rgba(20, 19, 19, 0.05);
            animation: slideIn 0.3s ease;
        }

        .resena-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 4px;
            font-size: 0.75rem;
            color: #888;
        }

        @keyframes slideIn {
            from { opacity: 0; transform: translateX(-10px); }
            to { opacity: 1; transform: translateX(0); }
        }

        .contenedor-resenas-locales::-webkit-scrollbar { width: 4px; }
        .contenedor-resenas-locales::-webkit-scrollbar-thumb { background: #ffa723; border-radius: 10px; }
    
        /* Estilos para el nuevo botón de PDF */
        .boton_subir_pdf {
            background-color: #e63946; /* Rojo para PDF */
            color: white;
            padding: 10px 15px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            font-size: 0.9rem;
            margin-right: 10px;
            display: flex;
            align-items: center;
            gap: 5px;
            transition: background 0.3s;
        }
        .boton_subir_pdf:hover {
            background-color: #c9302c;
        }
    </style>
</head>

<body>

    <div class="contenedor-busqueda">
        <form action="#" method="GET" class="formulario-busqueda" style="display: flex; margin-right: 15px;">
            <input type="text" placeholder="Buscar libros..." name="q" style="padding: 10px; border-radius: 20px 0 0 20px; border: 1px solid #445; background: #25343f; color: white; outline: none;">
            <button type="submit" style="padding: 10px; border-radius: 0 20px 20px 0; border: 1px solid #445; background: #25343f; cursor: pointer;">🔍</button>
        </form>
        
        <button id="btn-activar-pdf" class="boton_subir_pdf">
            📄 Subir PDF
        </button>
        <input type="file" id="input-subir-pdf" accept="application/pdf" style="display: none;">

        <button id="btn-subir-nuevo" class="boton_subir">Subir Nuevo</button>
    </div>

    <div class="contenido" id="contenedor-cartas"></div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btnSubir = document.getElementById('btn-subir-nuevo');
            const contenedor = document.getElementById('contenedor-cartas');

            // --- Lógica del Botón de PDF ---
            const btnActivarPdf = document.getElementById('btn-activar-pdf');
            const inputPdf = document.getElementById('input-subir-pdf');

            btnActivarPdf.addEventListener('click', function() {
                inputPdf.click(); // Abre la ventana de selección de archivos
            });

            // Detectar cuando el usuario selecciona un archivo
            inputPdf.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    const nombreArchivo = this.files[0].name;
                    contenedor.prepend(crearTarjeta(nombreArchivo, "Documento PDF", true));
                }
            });

            function crearTarjeta(titulo, autor, esPdf = false) {
                const nuevaTarjeta = document.createElement('article');
                nuevaTarjeta.className = 'card';
                
                // Determinamos qué logo mostrar
                const logoHtml = esPdf ? '📄 PDF' : '<span class="ai-logo">AI</span>';

                nuevaTarjeta.innerHTML = `
                    <div class="formulario-resena" style="padding: 20px; display: flex; flex-direction: column; min-height: 400px;">
                        <div class="card-header-internal">
                            <div>
                                <h2 class="card-title-text" style="font-size: 1.2rem; color: #333;">${titulo}</h2>
                                <p class="card-author-text">Por: ${autor}</p>
                            </div>
                            <span class="badge">NUEVO</span>
                        </div>
                        
                        <div class="contenedor-resenas-locales">
                            <p class="sin-resenas" style="font-size: 0.8rem; color: #aaa; text-align: center;">Aún no hay reseñas.</p>
                        </div>

                        <div class="seccion-input" style="margin-top: auto;">
                            <textarea class="input-opinion" rows="2" placeholder="Escribe tu comentario..." style="width:100%; border:1px solid #ddd; border-radius:8px; padding:10px; font-size: 0.9rem; resize: none;"></textarea>
                            <button type="button" class="boton_subir btn-enviar-resena" style="margin-top:8px; width:100%; padding: 10px;">Publicar Comentario</button>
                        </div>

                        <footer class="card-footer" style="margin-top:15px; display:flex; justify-content:flex-end; gap:10px; border-top: 1px solid #eee; padding-top: 10px;">
                            <button type="button" class="icon-btn Boton_editar btn-editar-card">✏️</button>
                            <button type="button" class="icon-btn delete-btn Boton_eliminar">🗑️</button>
                        </footer>
                    </div>
                `;

                // --- Lógica del botón ENVIAR RESEÑA ---
                const btnEnviar = nuevaTarjeta.querySelector('.btn-enviar-resena');
                const input = nuevaTarjeta.querySelector('.input-opinion');
                const cajaResenas = nuevaTarjeta.querySelector('.contenedor-resenas-locales');

                btnEnviar.addEventListener('click', () => {
                    const texto = input.value.trim();
                    if (texto !== "") {
                        const msgVacio = cajaResenas.querySelector('.sin-resenas');
                        if (msgVacio) msgVacio.remove();

                        const fecha = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                        const div = document.createElement('div');
                        div.className = 'resena-item';
                        div.innerHTML = `
                            <div class="resena-header">
                                <strong>Usuario</strong>
                                <span>${fecha}</span>
                            </div>
                            <div>${texto}</div>
                        `;
                        
                        cajaResenas.appendChild(div);
                        input.value = "";
                        cajaResenas.scrollTop = cajaResenas.scrollHeight;
                    }
                });

                // Editar Título
                nuevaTarjeta.querySelector('.btn-editar-card').addEventListener('click', () => {
                    const nuevoT = prompt("Nuevo título:", nuevaTarjeta.querySelector('.card-title-text').innerText);
                    if (nuevoT) nuevaTarjeta.querySelector('.card-title-text').innerText = nuevoT;
                });

                // Eliminar Tarjeta
                nuevaTarjeta.querySelector('.Boton_eliminar').addEventListener('click', () => {
                    if(confirm("¿Eliminar esta tarjeta y todas sus reseñas?")) nuevaTarjeta.remove();
                });

                return nuevaTarjeta;
            }

            btnSubir.addEventListener('click', () => {
                const t = prompt("Título del Libro:");
                const a = prompt("Autor:");
                if (t && a) contenedor.prepend(crearTarjeta(t, a));
            });

            contenedor.appendChild(crearTarjeta("El Gran Gatsby", "F. Scott Fitzgerald"));
        });
    </script>
</body>
</html>