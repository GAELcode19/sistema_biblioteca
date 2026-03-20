<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resena extends Model
{
    use HasFactory;

    // ESTO ES LO QUE FALTA: Dar permiso para llenar estas columnas
protected $fillable = [
    'articulo_id', 
    'nombre_usuario', 
    'puntuacion',   // <-- Cambiado
    'comentario'    // <-- Cambiado
];

    public function articulo() {
        return $this->belongsTo(Articulo::class);
    }
}