<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Hash; // Para encriptar las contraseñas
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Crear un usuario normal de prueba
        User::factory()->create([
            'name' => 'TestUser',
            'email' => 'test@example.com',
            'password' => Hash::make('123456789'),  // Aquí hasheamos la contraseña
        ]);

        // Crear un usuario administrador
        User::factory()->create([
            'name' => 'AdminUser',
            'email' => 'admin@example.com',
            'password' => Hash::make('123456789'),
            'role' => '1',
        ]);

        // Crear un usuario administrador
        User::factory()->create([
            'name' => 'Judit',
            'email' => 'juditquirosviolero@gmail.com',
            'password' => Hash::make('123456789'),
            'role' => '1',
        ]);

        // Llamar al seeder de productos e imágenes
        $this->call([
            ProductSeeder::class,
            ImageSeeder::class,
        ]);


    }
}
