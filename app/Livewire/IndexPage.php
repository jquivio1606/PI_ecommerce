<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;

class IndexPage extends Component
{
    public $categories = [];
    public $newProducts = [];
    public $discountedProducts = [];

    public function mount()
    {
        $this->categories = Product::whereNotNull('category')
            ->distinct()
            ->pluck('category')
            ->map(fn($cat) => ucfirst($cat))
            ->sort()
            ->values();

        $this->newProducts = Product::latest()->take(10)->get();

        $this->discountedProducts = Product::where('discount', '>', 0)
            ->take(10)
            ->get()
            ->map(function ($product) {
                $product->final_price = round($product->price * (1 - $product->discount / 100), 2);
                return $product;
            });
    }
    public function getProductDescription($product)
    {
        $isShoe = strtolower($product->category) === 'zapatos';

        $shoeTexts = [
            "¡Descubre el nuevo modelo de zapatos que está marcando tendencia! Hechos para acompañarte con estilo y comodidad todo el día.",
            "¿Buscas un calzado único? Estos zapatos son la combinación perfecta de diseño moderno y calidad.",
            "¡Tu próxima pisada con estilo empieza aquí! Disponible en tallas " . $product->sizes->pluck('name')->join(', ') . ".",
            "Dale un giro a tu estilo con este calzado nuevo. Comodidad y diseño que se adapta a ti.",
            "¿A la moda y cómodo? Estos zapatos tienen todo lo que necesitas para tus pasos diarios.",
            "Elige tu talla favorita y camina con seguridad. Disponible en: " . $product->sizes->pluck('name')->join(', ') . ".",
        ];

        $clothingTexts = [
            "Renueva tu armario con esta prenda imprescindible. Ideal para combinar con cualquier look.",
            "¡Moda que habla por ti! Esta novedad en " . strtolower($product->category) . " te hará destacar.",
            "Diseño, estilo y comodidad en una sola prenda. Disponible en tallas " . $product->sizes->pluck('name')->join(', ') . ".",
            "Perfecta para cualquier ocasión. Dale un toque fresco y actual a tu outfit.",
            "Te encantará cómo se ve y se siente esta nueva prenda. ¡No puede faltar en tu colección!",
            "Confeccionada con materiales de calidad. Disponible en: " . $product->sizes->pluck('name')->join(', ') . ".",
        ];

        return $isShoe
            ? $shoeTexts[array_rand($shoeTexts)]
            : $clothingTexts[array_rand($clothingTexts)];
    }



    public function render()
    {
        return view('livewire.index-page');
    }
}
