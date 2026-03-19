<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticuloController;

Route::get('/', function () {
    return redirect()->route('articulos.index');
});

Route::get('/articulos', [ArticuloController::class, 'index'])->name('articulos.index');
Route::get('/articulos/{articulo}', [ArticuloController::class, 'show'])->name('articulos.show');