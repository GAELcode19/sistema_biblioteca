<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticuloController;

// La ruta principal
Route::get('/', [ArticuloController::class, 'index'])->name('home');

// Ruta para el botón "Subir Nuevo" (el prompt de JS)
Route::post('/guardar-articulo', [ArticuloController::class, 'store'])->name('articulos.store');

// Ruta para los comentarios
Route::post('/guardar-resena', [ArticuloController::class, 'storeResena'])->name('resenas.store');

// Ruta para borrar
Route::delete('/eliminar-articulo/{id}', [ArticuloController::class, 'destroy'])->name('articulos.destroy');

// Ruta para editar
Route::put('/editar-articulo/{id}', [ArticuloController::class, 'update'])->name('articulos.update');