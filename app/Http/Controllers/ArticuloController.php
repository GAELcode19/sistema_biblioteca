<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Articulo;
use App\Models\Resena;

class ArticuloController extends Controller
{
public function index(Request $request) {
    // Empezamos a preparar la consulta trayendo también las reseñas
    $query = Articulo::with('resenas');

    // Si el usuario escribió algo en el buscador...
    if ($request->has('buscar') && $request->buscar != '') {
        $termino = $request->buscar;
        // Buscamos coincidencias en el título o en el autor
        $query->where('titulo', 'LIKE', '%' . $termino . '%')
              ->orWhere('autor', 'LIKE', '%' . $termino . '%');
    }

    // Traemos los resultados (ordenados de más nuevos a más viejos, opcional)
    $articulos = $query->latest()->get();
    
    return view('welcome', compact('articulos'));
}

public function store(Request $request) {
    $rutaPdf = null;

    // 1. Verificamos si el formulario trae un archivo PDF
    if ($request->hasFile('archivo_pdf')) {
        // 2. Lo guardamos en la carpeta 'storage/app/public/pdfs'
        $rutaPdf = $request->file('archivo_pdf')->store('pdfs', 'public');
    }

    // 3. Creamos el artículo en la base de datos
    Articulo::create([
        'titulo' => $request->titulo,
        'autor' => $request->autor,
        'categoria_id' => 1,
        'contenido_texto' => 'Sin descripción',
        'archivo_pdf' => $rutaPdf // <- Guardamos la ruta del archivo
    ]);
    
    return redirect()->route('home');
}

public function storeResena(Request $request) {
    Resena::create([
        'articulo_id' => $request->articulo_id,
        'comentario' => $request->comentario,
        'nombre_usuario' => 'Usuario', 
        'puntuacion' => $request->puntuacion // <-- ¡Aquí ocurre la magia!
    ]);
    
    return back();
}

    public function destroy($id) {
        Articulo::findOrFail($id)->delete();
        return back();
    }

    public function update(Request $request, $id) {
    // 1. Buscamos el libro en la base de datos
    $articulo = Articulo::findOrFail($id);
    
    // 2. Actualizamos solo el título y el autor
    $articulo->update([
        'titulo' => $request->titulo,
        'autor' => $request->autor,
    ]);
    
    // 3. Respondemos que todo salió bien (para que JS lo sepa)
    return response()->json(['success' => true]);
}
}

