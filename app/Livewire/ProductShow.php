<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;

class ProductShow extends Component
{
    // Propiedad pública para almacenar el producto que se va a mostrar
    public $product;

    /**
     * Método que se ejecuta cuando se monta el componente.
     * Carga el producto desde la base de datos usando el ID proporcionado.
     *
     * @param int $id ID del producto a mostrar
     */
    public function mount($id)
    {
        // Busca el producto por ID. Si no lo encuentra, lanza un error 404.
        $this->product = Product::findOrFail($id);
    }

    /**
     * Renderiza la vista asociada a este componente.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        // Devuelve la vista 'livewire.product-show' con los datos del producto
        return view('livewire.product-show');
    }
}
