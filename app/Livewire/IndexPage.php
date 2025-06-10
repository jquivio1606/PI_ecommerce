<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;

class IndexPage extends Component
{
    // Variables públicas que estarán disponibles en la vista
    public $categories = [];         // Lista de categorías únicas de productos
    public $newProducts = [];        // Últimos productos añadidos
    public $discountedProducts = []; // Productos con descuento

    /**
     * Este método se ejecuta al montar el componente.
     * Aquí se cargan las categorías, los nuevos productos y los productos en oferta.
     */
    public function mount()
    {
        // Obtener las categorías únicas no nulas, capitalizarlas, ordenarlas alfabéticamente y resetear los índices
        $this->categories = Product::whereNotNull('category')
            ->distinct()
            ->pluck('category')   // Trae solo los valores únicos de la columna 'category'
            ->map(fn($cat) => ucfirst($cat))    // Capitaliza la primera letra
            ->sort()    // Ordena alfabéticamente
            ->values();     // Reinicia los índices para que el array sea limpio

        // Obtener los 10 productos más recientes
        $this->newProducts = Product::latest()->take(10)->get();

        // Obtener los productos con descuento y calcular su precio final
        $this->discountedProducts = Product::where('discount', '>', 0)
            ->take(10)
            ->get()
            ->map(function ($product) {
                // Calcular el precio con descuento y asignarlo al producto
                $product->final_price = round($product->price * (1 - $product->discount / 100), 2);
                return $product;
            });
    }

    /**
     * Genera una descripción aleatoria para un producto según su categoría.
     *
     * @param Product $product
     * @return string
     */
    public function getProductDescription($product)
    {
        $isShoe = strtolower($product->category) === 'zapatos'; // Verifica si el producto es de categoría "zapatos"

        // Frases para productos de calzado
        $shoeTexts = [
            "¡Descubre el nuevo modelo de zapatos que está marcando tendencia! Hechos para acompañarte con estilo y comodidad todo el día.",
            "¿Buscas un calzado único? Estos zapatos son la combinación perfecta de diseño moderno y calidad.",
            "¡Tu próxima pisada con estilo empieza aquí! Disponible en tallas " . $product->sizes->pluck('name')->join(', ') . ".",
            "Dale un giro a tu estilo con este calzado nuevo. Comodidad y diseño que se adapta a ti.",
            "¿A la moda y cómodo? Estos zapatos tienen todo lo que necesitas para tus pasos diarios.",
            "Elige tu talla favorita y camina con seguridad. Disponible en: " . $product->sizes->pluck('name')->join(', ') . ".",
        ];

        // Frases para otras prendas (ropa en general)
        $clothingTexts = [
            "Renueva tu armario con esta prenda imprescindible. Ideal para combinar con cualquier look.",
            "¡Moda que habla por ti! Esta novedad en " . strtolower($product->category) . " te hará destacar.",
            "Diseño, estilo y comodidad en una sola prenda. Disponible en tallas " . $product->sizes->pluck('name')->join(', ') . ".",
            "Perfecta para cualquier ocasión. Dale un toque fresco y actual a tu outfit.",
            "Te encantará cómo se ve y se siente esta nueva prenda. ¡No puede faltar en tu colección!",
            "Confeccionada con materiales de calidad. Disponible en: " . $product->sizes->pluck('name')->join(', ') . ".",
        ];

        // Devuelve un texto aleatorio dependiendo de si es zapato u otra prenda
        return $isShoe
            ? $shoeTexts[array_rand($shoeTexts)]
            : $clothingTexts[array_rand($clothingTexts)];
    }

    /**
     * Renderiza la vista de la página de inicio (home).
     */
    public function render()
    {
        return view('livewire.index-page');
    }
}
