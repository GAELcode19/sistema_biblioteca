<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Articulo extends Model {
    use HasFactory;

    protected $fillable = ['titulo', 'autor', 'categoria_id', 'contenido_texto', 'archivo_pdf'];

    /**
     * Relación: Un artículo pertenece a una categoría.
     */
    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    /**
     * Relación: Un artículo tiene muchas reseñas.
     */
    public function resenas()
    {
        return $this->hasMany(Resena::class);
    }
}