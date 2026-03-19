<?php

namespace App\Http\Controllers;

use App\Models\Articulo;
use App\Models\Categoria;
use Illuminate\Http\Request;

class ArticuloController extends Controller
{
    /**
     * Muestra la página principal con los artículos y categorías.
     */
    public function index()
    {
        // Traemos los artículos con su categoría (Eager Loading)
        $articulos = Articulo::with('categoria')->get();
        
        // Traemos todas las categorías para el menú desplegable del formulario
        $categorias = Categoria::all();

        return view('welcome', compact('articulos', 'categorias'));
    }

    /**
     * Guarda un nuevo artículo en la base de datos.
     */
    public function store(Request $request)
    {
        // 1. VALIDACIÓN: Aquí forzamos que el autor no tenga números
        $request->validate([
            'titulo' => 'required|string|max:255',
            'autor' => 'required|regex:/^[a-zA-Z\s\á\é\í\ó\ú\Á\É\Í\Ó\Ú\ñ\Ñ]+$/', // Solo letras y espacios
            'categoria_id' => 'required|exists:categorias,id',
            'archivo_pdf' => 'required|mimes:pdf|max:10000', // Máximo 10MB
            'contenido_texto' => 'nullable|string',
        ], [
            'autor.regex' => 'Error: El nombre del autor solo puede contener letras.',
            'archivo_pdf.mimes' => 'El archivo debe ser un formato PDF válido.',
        ]);

        // 2. GUARDAR EL ARCHIVO PDF
        // Se guarda en storage/app/public/articulos_pdfs
        $rutaPdf = $request->file('archivo_pdf')->store('articulos_pdfs', 'public');

        // 3. CREAR EL REGISTRO EN POSTGRESQL
        Articulo::create([
            'titulo' => $request->titulo,
            'autor' => $request->autor,
            'categoria_id' => $request->categoria_id,
            'archivo_pdf' => $rutaPdf,
            'contenido_texto' => $request->contenido_texto ?? '',
        ]);

        // 4. REGRESAR A LA PÁGINA CON MENSAJE DE ÉXITO
        return back()->with('success', '¡El artículo se ha publicado correctamente!');
    }
}