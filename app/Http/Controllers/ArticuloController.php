<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Articulo;
use App\Models\Resena;

class ArticuloController extends Controller
{
    public function index() {
        $articulos = Articulo::with('resenas')->orderBy('created_at', 'desc')->get();
        return view('welcome', compact('articulos'));
    }

    public function store(Request $request) {
        Articulo::create([
            'titulo' => $request->titulo,
            'autor' => $request->autor,
            'categoria_id' => 1,
            'contenido_texto' => 'Sin descripción'
        ]);
        return redirect()->route('home');
    }

    public function storeResena(Request $request) {
        Resena::create([
            'articulo_id' => $request->articulo_id,
            'contenido_texto' => $request->contenido_texto,
        ]);
        return back();
    }

    public function destroy($id) {
        Articulo::findOrFail($id)->delete();
        return back();
    }
}