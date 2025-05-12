<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;

class AdminDashboard extends Component
{
    public $lowStockProducts = [];

    public function mount()
    {
        // Obtener los productos con alguna talla con stock bajo (menos de 5 unidades)
        $this->lowStockProducts = Product::whereHas('sizes', function ($query) {
            $query->where('product_size.stock', '<=', 5);
        })
        ->with(['sizes' => function ($query) {
            $query->where('product_size.stock', '<=', 5);
        }])
        ->get();
    }


    public function render()
    {
        return view('livewire.admin-dashboard', [
            'products' => Product::all(),
            'orders' => Order::all(),
            'users' => User::all(),
            'recentOrders' => Order::latest()->take(5)->get(),
            'recentProducts' => Product::latest()->take(5)->get(),
        ]);
    }
}
