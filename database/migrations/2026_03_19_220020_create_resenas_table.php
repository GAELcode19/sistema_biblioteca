<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('resenas', function (Blueprint $table) {
        $table->id();
        // Relación con el artículo: si se borra el artículo, se borran sus reseñas
        $table->foreignId('articulo_id')->constrained('articulos')->onDelete('cascade');
        
        $table->string('nombre_usuario'); // Quien escribe la reseña
        $table->text('comentario');       // El texto de la opinión
        $table->integer('puntuacion');    // Calificación (1 al 5)
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resenas');
    }
};
