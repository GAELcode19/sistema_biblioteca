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
                
                // Creamos un ID único para que las estrellas de esta tarjeta no choquen con otras
                const idUnico = 'tarjeta_' + Math.random().toString(36).substr(2, 9);

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
                            <div class="rating-container" style="margin-bottom: 10px;">
                                <span class="rating-text" style="font-size: 0.9rem; margin-bottom: 5px; display: block;">Tu calificación:</span>
                                <div class="rating">
                                    <input value="5" name="rate_${idUnico}" id="star5_${idUnico}" type="radio">
                                    <label title="5 estrellas" for="star5_${idUnico}"></label>
                                    <input value="4" name="rate_${idUnico}" id="star4_${idUnico}" type="radio">
                                    <label title="4 estrellas" for="star4_${idUnico}"></label>
                                    <input value="3" name="rate_${idUnico}" id="star3_${idUnico}" type="radio">
                                    <label title="3 estrellas" for="star3_${idUnico}"></label>
                                    <input value="2" name="rate_${idUnico}" id="star2_${idUnico}" type="radio">
                                    <label title="2 estrellas" for="star2_${idUnico}"></label>
                                    <input value="1" name="rate_${idUnico}" id="star1_${idUnico}" type="radio">
                                    <label title="1 estrella" for="star1_${idUnico}"></label>
                                </div>
                            </div>

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