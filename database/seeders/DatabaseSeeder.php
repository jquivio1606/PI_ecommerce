<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Hash; // Asegúrate de incluir esta clase al inicio del archivo

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'TestUser',
            'email' => 'test@example.com',
            'password' =>  '123456789',
        ]);

        User::factory()->create([
            'name' => 'AdminUser',
            'email' => 'admin@example.com',
            'password' => '123456789',
        ]);

        $this->call([
            ProductSeeder::class,
        ]);
    }
}
