<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class SeeMyOrders extends Component
{
    // Propiedad pública para almacenar los pedidos del usuario autenticado
    public $orders;

    /**
     * Método que se ejecuta al montar el componente.
     * Obtiene todos los pedidos del usuario autenticado junto con sus detalles.
     */
    public function mount()
    {
        $this->orders = Auth::user()
            ->orders()
            // Cargamos en la misma consulta los productos y tallas de cada item del pedido para optimizar
            ->with('items.product', 'items.size')
            ->get();
    }

    /**
     * Renderiza la vista asociada a este componente.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        // Devuelve la vista 'livewire.see-my-orders' que mostrará los pedidos
        return view('livewire.see-my-orders');
    }
}
