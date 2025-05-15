<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Size;
use App\Models\Image;

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

        $sizes = Size::all();

        $products = [
            ['name' => 'Camiseta Relax', 'description' => 'Camiseta cómoda de algodón 100% para cualquier ocasión casual.', 'category' => 'Camisetas', 'gender' => 'Unisex', 'style' => 'Casual', 'color' => 'Rojo', 'price' => 19.99],
            ['name' => 'Pantalón Deportivo', 'description' => 'Pantalón deportivo de felpa con corte slim para entrenar.', 'category' => 'Pantalones', 'gender' => 'Hombre', 'style' => 'Deportivo', 'color' => 'Azul', 'price' => 39.99],
            ['name' => 'Chaqueta Elegante', 'description' => 'Chaqueta de lana en color gris, perfecta para eventos formales.', 'category' => 'Chaquetas', 'gender' => 'Mujer', 'style' => 'Elegante', 'color' => 'Gris', 'price' => 89.99],
            ['name' => 'Zapatos de Cuero', 'description' => 'Zapatos de cuero negro de alta calidad, ideales para ocasiones formales.', 'category' => 'Zapatos', 'gender' => 'Unisex', 'style' => 'Elegante', 'color' => 'Negro', 'price' => 120.00],
            ['name' => 'Sudadera Con Capucha', 'description' => 'Sudadera cómoda con capucha, ideal para el invierno.', 'category' => 'Sudaderas', 'gender' => 'Hombre', 'style' => 'Deportivo', 'color' => 'Blanco', 'price' => 49.99],
            ['name' => 'Vestido de Noche', 'description' => 'Vestido largo de noche con encaje y detalles brillantes.', 'category' => 'Vestidos', 'gender' => 'Mujer', 'style' => 'Elegante', 'color' => 'Beige', 'price' => 150.00],
            ['name' => 'Falda Midi', 'description' => 'Falda midi con tela fluida, perfecta para el verano.', 'category' => 'Faldas', 'gender' => 'Mujer', 'style' => 'Casual', 'color' => 'Verde', 'price' => 34.99],
            ['name' => 'Camiseta Deportiva', 'description' => 'Camiseta técnica ideal para entrenamiento intensivo.', 'category' => 'Camisetas', 'gender' => 'Unisex', 'style' => 'Deportivo', 'color' => 'Negro', 'price' => 25.99],
            ['name' => 'Pantalón Cargo', 'description' => 'Pantalón cargo cómodo y práctico, con múltiples bolsillos.', 'category' => 'Pantalones', 'gender' => 'Unisex', 'style' => 'Casual', 'color' => 'Gris', 'price' => 45.00],
            ['name' => 'Blusa de Seda', 'description' => 'Blusa elegante de seda, ideal para salidas nocturnas.', 'category' => 'Camisetas', 'gender' => 'Mujer', 'style' => 'Elegante', 'color' => 'Blanco', 'price' => 70.00],
            ['name' => 'Chaqueta de Cuero', 'description' => 'Chaqueta de cuero negro con detalles metálicos, un clásico.', 'category' => 'Chaquetas', 'gender' => 'Hombre', 'style' => 'Moderno', 'color' => 'Negro', 'price' => 200.00],
            ['name' => 'Botines de Cuero', 'description' => 'Botines de cuero con suela gruesa, para el día a día.', 'category' => 'Zapatos', 'gender' => 'Mujer', 'style' => 'Casual', 'color' => 'Beige', 'price' => 85.00],
            ['name' => 'Pantalón Slim Fit', 'description' => 'Pantalón slim fit con corte moderno, cómodo y elegante.', 'category' => 'Pantalones', 'gender' => 'Hombre', 'style' => 'Clásico', 'color' => 'Negro', 'price' => 60.00],
            ['name' => 'Camiseta Básica', 'description' => 'Camiseta básica para el uso diario, de algodón suave.', 'category' => 'Camisetas', 'gender' => 'Unisex', 'style' => 'Clásico', 'color' => 'Azul', 'price' => 15.00],
            ['name' => 'Sudadera con Logo', 'description' => 'Sudadera con logo grande en el pecho, cómoda y de estilo urbano.', 'category' => 'Sudaderas', 'gender' => 'Unisex', 'style' => 'Deportivo', 'color' => 'Rojo', 'price' => 55.00],
            ['name' => 'Vestido Corto', 'description' => 'Vestido corto de verano, cómodo y fresco para el calor.', 'category' => 'Vestidos', 'gender' => 'Mujer', 'style' => 'Casual', 'color' => 'Azul', 'price' => 40.00],
            ['name' => 'Camiseta de Rayas', 'description' => 'Camiseta de rayas en tonos clásicos, un must en tu armario.', 'category' => 'Camisetas', 'gender' => 'Mujer', 'style' => 'Clásico', 'color' => 'Blanco', 'price' => 29.99],
            ['name' => 'Pantalón Formal', 'description' => 'Pantalón formal en color negro, ideal para oficina o eventos elegantes.', 'category' => 'Pantalones', 'gender' => 'Hombre', 'style' => 'Elegante', 'color' => 'Negro', 'price' => 80.00],
            ['name' => 'Falda Larga', 'description' => 'Falda larga en tela fluida, perfecta para el verano o el estilo bohemio.', 'category' => 'Faldas', 'gender' => 'Mujer', 'style' => 'Casual', 'color' => 'Beige', 'price' => 30.00],
            ['name' => 'Botas Altas', 'description' => 'Botas altas de cuero con detalle de hebillas, para el invierno.', 'category' => 'Zapatos', 'gender' => 'Mujer', 'style' => 'Elegante', 'color' => 'Negro', 'price' => 120.00]
        ];

        $discounts = [5, 10, 15, 20, 30, 50, 75, 90];
        $index = 0;

        foreach ($products as $productData) {
            $discount = null;
            if ($index < count($discounts)) {
                $discount = $discounts[$index];
                $index++;
            }

            $product = Product::create([
                'name' => $productData['name'],
                'description' => $productData['description'],
                'color' => $productData['color'],
                'gender' => $productData['gender'],
                'style' => $productData['style'],
                'category' => $productData['category'],
                'price' => $productData['price'],
                'discount' => $discount,
            ]);

            $assignedSizes = $sizes->random(rand(1, $sizes->count()));

            foreach ($assignedSizes as $size) {
                $product->sizes()->attach($size->id, [
                    'stock' => rand(5, 50),
                ]);
            }

            $numberOfImages = rand(1, 3);
            for ($j = 0; $j < $numberOfImages; $j++) {
                $imageUrl = 'https://picsum.photos/seed/' . rand(1, 1000) . '/200/200';

                Image::create([
                    'product_id' => $product->id,
                    'url' => $imageUrl,
                ]);
            }
        }
    }
}
