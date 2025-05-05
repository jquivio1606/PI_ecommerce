<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Size;




class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sizes = ['XS', 'S', 'M', 'L', 'XL', 'XXL'];

        foreach ($sizes as $size) {
            Size::create(['name' => $size]);
        }

        $genders = ['Hombre', 'Mujer', 'Unisex'];
        $styles = ['Clásico', 'Moderno', 'Deportivo', 'Elegante', 'Casual'];
        $colors = ['Rojo', 'Azul', 'Negro', 'Blanco', 'Verde', 'Gris', 'Beige'];
        $categories = ['Camisetas', 'Pantalones', 'Chaquetas', 'Zapatos', 'Sudaderas', 'Vestidos', 'Faldas'];

        $sizes = Size::all(); // asegúrate de tener tallas creadas previamente

        for ($i = 0; $i < 50; $i++) {
            $product = Product::create([
                'name' => ucfirst(fake()->words(2, true)),
                'description' => fake()->sentence(),
                'color' => fake()->randomElement($colors),
                'gender' => fake()->randomElement($genders),
                'style' => fake()->randomElement($styles),
                'category' => fake()->randomElement($categories),
                'price' => fake()->randomFloat(2, 10, 200),
            ]);

            // Asignar aleatoriamente stock a algunas tallas
            $assignedSizes = $sizes->random(rand(1, $sizes->count()));

            foreach ($assignedSizes as $size) {
                $product->sizes()->attach($size->id, [
                    'stock' => fake()->numberBetween(5, 50),
                ]);
            }
        }
    }
}
