<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Resena extends Model {
    use HasFactory;

    protected $fillable = ['articulo_id', 'nombre_usuario', 'comentario', 'puntuacion'];

    /**
     * Relación: Una reseña pertenece a un artículo.
     */
    public function articulo()
    {
        return $this->belongsTo(Articulo::class);
    }
}