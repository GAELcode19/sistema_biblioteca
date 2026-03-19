<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Categoria;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Creamos las categorías (Importante para que aparezcan en tu formulario)
        Categoria::create(['nombre' => 'Científico']);
        Categoria::create(['nombre' => 'Literario']);
        Categoria::create(['nombre' => 'Informativo']);
        Categoria::create(['nombre' => 'Histórico']);

        // 2. Creamos un usuario de prueba con tus campos personalizados
        User::factory()->create([
            'nombre_completo' => 'Miguel Mendoza',
            'username' => 'Miguel123',
            'email' => 'test@example.com',
            'password' => bcrypt('12345678'), // Siempre encriptar la contraseña
        ]);
    }
}