<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class SeeMyOrders extends Component
{
    public $orders;

    public function mount()
    {
        $this->orders = Auth::user()
            ->orders()
            ->with('items.product', 'items.size') // Cargamos productos y tallas
            ->get();
    }

    public function render()
    {
        return view('livewire.see-my-orders');
    }
}
