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
    Schema::create('articulos', function (Blueprint $table) {
        $table->id();
        $table->string('titulo');
        $table->string('autor'); 
        // Esta línea es la que une el artículo con la categoría que acabas de crear:
        $table->foreignId('categoria_id')->constrained('categorias'); 
        
        $table->longText('contenido_texto')->nullable(); // Para escribir manual
        $table->string('archivo_pdf')->nullable();      // Para subir el archivo
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articulos');
    }
};
