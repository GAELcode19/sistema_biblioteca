<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticuloController;

// 1. Esta ruta usa el controlador para traer los datos reales de la base de datos (PostgreSQL)
Route::get('/', [ArticuloController::class, 'index'])->name('home');

// 2. Esta ruta es la que procesa el formulario de "Subir" y guarda el archivo PDF
Route::post('/subir-articulo', [ArticuloController::class, 'store'])->name('articulos.store');