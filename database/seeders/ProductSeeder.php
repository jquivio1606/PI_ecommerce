<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Size;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Crear tallas de ropa
        $clothingSizes = ['XS', 'S', 'M', 'L', 'XL', 'XXL'];
        foreach ($clothingSizes as $size) {
            Size::create(['name' => $size]);
        }

        // Crear tallas de Calzado del 36 al 45
        for ($i = 36; $i <= 45; $i++) {
            Size::create(['name' => (string) $i]);
        }

        // Obtener todas las tallas ya creadas (ropa + Calzado)
        $sizes = Size::all();

        // Separar tallas numéricas (Calzado) y no numéricas (ropa)
        $shoeSizes = $sizes->filter(fn($s) => is_numeric($s->name));
        $clothingSizes = $sizes->filter(fn($s) => !is_numeric($s->name));

        // Definición del array de productos con sus datos
        $products = [
            ['name' => 'Abrigo largo de paño', 'description' => 'Abrigo largo de paño, ideal para invierno.', 'style' => 'Elegante', 'gender' => 'Mujer', 'color' => 'Camel', 'category' => 'Abrigos', 'price' => 89.99],
            ['name' => 'Chaqueta ajustada', 'description' => 'Chaqueta ajustada para oficina o eventos formales.', 'style' => 'Elegante', 'gender' => 'Hombre', 'color' => 'Negro', 'category' => 'Chaquetas', 'price' => 69.99],
            ['name' => 'Botas altas de cuero', 'description' => 'Botas altas de cuero con detalle de hebillas, para el invierno.', 'style' => 'Elegante', 'gender' => 'Mujer', 'color' => 'Negro', 'category' => 'Calzado', 'price' => 99.99],
            ['name' => 'Botas de montaña', 'description' => 'Botas de montaña resistentes y cómodas.', 'style' => 'Deportivo', 'gender' => 'Unisex', 'color' => 'Marrón', 'category' => 'Calzado', 'price' => 84.99],
            ['name' => 'Camisa de lino', 'description' => 'Camisa de lino ligera, perfecta para el verano.', 'style' => 'Casual', 'gender' => 'Hombre', 'color' => 'Blanco', 'category' => 'Camisas', 'price' => 39.99],
            ['name' => 'Camiseta Relax', 'description' => 'Camiseta cómoda de algodón 100% para cualquier ocasión casual.', 'style' => 'Casual', 'gender' => 'Unisex', 'color' => 'Rojo', 'category' => 'Camisetas', 'price' => 19.99],
            ['name' => 'Camiseta gráfica', 'description' => 'Camiseta con cuello en V y estampado gráfico.', 'style' => 'Casual', 'gender' => 'Unisex', 'color' => 'Blanco', 'category' => 'Camisetas', 'price' => 22.99],
            ['name' => 'Camiseta de rayas', 'description' => 'Camiseta de rayas en tonos clásicos, un must en tu armario.', 'style' => 'Clásico', 'gender' => 'Mujer', 'color' => 'Blanco', 'category' => 'Camisetas', 'price' => 24.99],
            ['name' => 'Chaqueta de cuero', 'description' => 'Chaqueta de cuero negro con detalles metálicos, un clásico.', 'style' => 'Moderno', 'gender' => 'Hombre', 'color' => 'Negro', 'category' => 'Chaquetas', 'price' => 129.99],
            ['name' => 'Chaqueta de lana', 'description' => 'Chaqueta de lana en color gris, perfecta para eventos formales.', 'style' => 'Elegante', 'gender' => 'Mujer', 'color' => 'Gris', 'category' => 'Chaquetas', 'price' => 89.99],
            ['name' => 'Chaqueta impermeable', 'description' => 'Chaqueta impermeable con capucha para lluvia.', 'style' => 'Deportivo', 'gender' => 'Unisex', 'color' => 'Azul Marino', 'category' => 'Chaquetas', 'price' => 74.99],
            ['name' => 'Conjunto casual femenino', 'description' => 'Conjunto casual femenino con blusa blanca ligera y falda midi fluida beige, perfecto para días cálidos.', 'style' => 'Casual', 'gender' => 'Mujer', 'color' => 'Beige', 'category' => 'Conjuntos', 'price' => 59.99],
            ['name' => 'Conjunto deportivo verde', 'description' => 'Conjunto deportivo compuesto por sudadera con capucha y pantalón deportivo en color verde, cómodo y funcional para entrenamientos.', 'style' => 'Deportivo', 'gender' => 'Unisex', 'color' => 'Verde', 'category' => 'Conjuntos', 'price' => 64.99],
            ['name' => 'Chaleco elegante gris', 'description' => 'Elegante chaleco de vestir en gris oscuro, ideal para eventos y oficina.', 'style' => 'Elegante', 'gender' => 'Hombre', 'color' => 'Gris', 'category' => 'Chalecos', 'price' => 49.99],
            ['name' => 'Conjunto elegante completo', 'description' => 'Elegante conjunto elegante que incluye chaqueta, chaleco y pantalón de vestir en gris oscuro, ideal para eventos y oficina.', 'style' => 'Elegante', 'gender' => 'Hombre', 'color' => 'Gris', 'category' => 'Conjuntos', 'price' => 149.99],
            ['name' => 'Falda larga beige', 'description' => 'Falda larga en tela fluida, perfecta para el verano o el estilo bohemio.', 'style' => 'Casual', 'gender' => 'Mujer', 'color' => 'Beige', 'category' => 'Faldas', 'price' => 34.99],
            ['name' => 'Falda floral', 'description' => 'Falda plisada midi con diseño floral.', 'style' => 'Bohemio', 'gender' => 'Mujer', 'color' => 'Rosa', 'category' => 'Faldas', 'price' => 39.99],
            ['name' => 'Jersey grueso', 'description' => 'Jersey de lana gruesa para días fríos.', 'style' => 'Casual', 'gender' => 'Mujer', 'color' => 'Gris Claro', 'category' => 'Jerseys', 'price' => 49.99],
            ['name' => 'Jersey fino beige', 'description' => 'Jersey de punto fino para uso diario.', 'style' => 'Casual', 'gender' => 'Unisex', 'color' => 'Beige', 'category' => 'Jerseys', 'price' => 39.99],
            ['name' => 'Pantalón cargo', 'description' => 'Pantalón cargo cómodo y práctico, con múltiples bolsillos.', 'style' => 'Casual', 'gender' => 'Unisex', 'color' => 'Gris', 'category' => 'Pantalones', 'price' => 34.99],
            ['name' => 'Pantalón deportivo azul', 'description' => 'Pantalón deportivo de felpa con corte slim para entrenar.', 'style' => 'Deportivo', 'gender' => 'Hombre', 'color' => 'Azul', 'category' => 'Pantalones', 'price' => 29.99],
            ['name' => 'Pantalón elegante negro', 'description' => 'Pantalón elegante en color negro, ideal para oficina o eventos elegantes.', 'style' => 'Elegante', 'gender' => 'Hombre', 'color' => 'Negro', 'category' => 'Pantalones', 'price' => 44.99],
            ['name' => 'Pantalón palazzo', 'description' => 'Pantalón palazzo fluido y elegante.', 'style' => 'Elegante', 'gender' => 'Mujer', 'color' => 'Negro', 'category' => 'Pantalones', 'price' => 42.99],
            ['name' => 'Pantalones cortos', 'description' => 'Pantalones cortos de mezclilla desgastados.', 'style' => 'Casual', 'gender' => 'Unisex', 'color' => 'Azul Claro', 'category' => 'Pantalones', 'price' => 24.99],
            ['name' => 'Sandalias de cuero', 'description' => 'Sandalias de cuero con tiras finas.', 'style' => 'Casual', 'gender' => 'Mujer', 'color' => 'Marrón', 'category' => 'Calzado', 'price' => 34.99],
            ['name' => 'Sudadera blanca', 'description' => 'Sudadera cómoda con capucha, ideal para el invierno.', 'style' => 'Deportivo', 'gender' => 'Hombre', 'color' => 'Blanco', 'category' => 'Sudaderas', 'price' => 39.99],
            ['name' => 'Sudadera oversize gris', 'description' => 'Sudadera oversize con bolsillo canguro.', 'style' => 'Urbano', 'gender' => 'Unisex', 'color' => 'Gris Oscuro', 'category' => 'Sudaderas', 'price' => 44.99],
            ['name' => 'Conjunto urbano negro', 'description' => 'Sudadera oversize negra y pantalón jogger ajustado en tejido cómodo, ideal para un look urbano moderno.', 'style' => 'Urbano', 'gender' => 'Unisex', 'color' => 'Negro', 'category' => 'Conjuntos', 'price' => 69.99],
            ['name' => 'Vestido corto de verano', 'description' => 'Vestido corto de verano, cómodo y fresco para el calor.', 'style' => 'Casual', 'gender' => 'Mujer', 'color' => 'Azul', 'category' => 'Vestidos', 'price' => 34.99],
            ['name' => 'Vestido de playa marinero', 'description' => 'Vestido de playa marinero, ideal para la playa', 'style' => 'Bohemio', 'gender' => 'Mujer', 'color' => 'Blanco', 'category' => 'Vestidos', 'price' => 29.99],
            ['name' => 'Vestido de playa', 'description' => 'Vestido de playa, ideal para la playa', 'style' => 'Bohemio', 'gender' => 'Mujer', 'color' => 'Blanco', 'category' => 'Vestidos', 'price' => 29.99],
            ['name' => 'Vestido largo de noche beige', 'description' => 'Vestido largo de noche con encaje y detalles brillantes.', 'style' => 'Elegante', 'gender' => 'Mujer', 'color' => 'Beige', 'category' => 'Vestidos', 'price' => 89.99],
            ['name' => 'Vestido largo de noche turquesa', 'description' => 'Vestido largo de noche con encaje y detalles brillantes.', 'style' => 'Elegante', 'gender' => 'Mujer', 'color' => 'Turquesa', 'category' => 'Vestidos', 'price' => 89.99],
            ['name' => 'Calzado de cuero negro', 'description' => 'Calzado de cuero negro de alta calidad, ideales para ocasiones formales.', 'style' => 'Elegante', 'gender' => 'Unisex', 'color' => 'Negro', 'category' => 'Calzado', 'price' => 79.99],
            ['name' => 'Calzado deportivos blancos', 'description' => 'Calzado de deporte y, para el día a día.', 'style' => 'Deportivo', 'gender' => 'Unisex', 'color' => 'Blancos', 'category' => 'Calzado', 'price' => 59.99],
            ['name' => 'Calzado casuales naranjas', 'description' => 'Calzado para salir, tipo converse.', 'style' => 'Casual', 'gender' => 'Unisex', 'color' => 'Naranja', 'category' => 'Calzado', 'price' => 39.99],
        ];


        // Array de descuentos para algunos productos (en porcentaje)
        $discounts = [5, 10, 15, 20, 30, 50, 75, 90];
        $index = 0;

        foreach ($products as $productData) {
            $discount = null;

            // Asignar descuento si hay disponible en la lista
            if ($index < count($discounts)) {
                $discount = $discounts[$index];
                $index++;
            }

            // Crear el producto en la base de datos
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

            // Seleccionar el pool de tallas según categoría del producto
            $sizePool = $productData['category'] === 'Calzado' ? $shoeSizes : $clothingSizes;

            // Asignar entre 1 y todas las tallas disponibles al producto, al azar
            $assignedSizes = $sizePool->random(rand(1, $sizePool->count()));

            // Relacionar las tallas con el producto y asignar un stock aleatorio entre 5 y 50
            foreach ($assignedSizes as $size) {
                $product->sizes()->attach($size->id, [
                    'stock' => rand(5, 50),
                ]);
            }
        }
    }
}
