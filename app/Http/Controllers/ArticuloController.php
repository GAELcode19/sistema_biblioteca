<?php

namespace App\Http\Controllers;

use App\Models\Articulo;

class ArticuloController extends Controller
{
    public function index()
    {
        $articulos = Articulo::latest()->get();

        return view('articulos.index', compact('articulos'));
    }

    public function show(Articulo $articulo)
    {
        return view('articulos.show', compact('articulo'));
    }
}