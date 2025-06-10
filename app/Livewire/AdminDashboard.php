<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;

class AdminDashboard extends Component
{
    // Lista de productos con stock bajo en alguna talla
    public $lowStockProducts = [];

    /**
     * Este método se ejecuta automáticamente cuando se monta el componente.
     * Se encarga de buscar los productos con tallas cuyo stock sea menor o igual a 5.
     */
    public function mount()
    {
        // Filtrar productos que tengan al menos una talla con poco stock (<= 5)
        $this->lowStockProducts = Product::whereHas('sizes', function ($query) {
            $query->where('product_size.stock', '<=', 5); // Condición sobre la tabla intermedia product_size
        })
            ->with([
                'sizes' => function ($query) {
                    $query->where('product_size.stock', '<=', 5); // Cargar solo las tallas con bajo stock
                }
            ])
            ->get(); // Obtener los productos que cumplen con esa condición
    }

    /**
     * Renderiza la vista del dashboard del administrador con estadísticas y registros recientes.
     */
    public function render()
    {
        return view('livewire.admin-dashboard', [
            'products' => Product::all(),   // Todos los productos
            'orders' => Order::all(),       // Todos los pedidos
            'users' => User::all(),         // Todos los usuarios
            'recentOrders' => Order::latest()->take(5)->get(),       // Últimos 5 pedidos
            'recentProducts' => Product::latest()->take(5)->get(),   // Últimos 5 productos añadidos
        ]);
    }
}
