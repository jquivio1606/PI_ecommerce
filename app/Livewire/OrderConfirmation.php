<?php

namespace App\Livewire;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use App\Models\OrderItem;
use App\Models\Order;

class OrderConfirmation extends Component
{
    public $selectedItems = [];
    public $cartItems;
    public $totalPrice = 0;

    public function mount()
    {
        // Recuperamos los productos seleccionados desde la sesión
        $this->selectedItems = session('selectedItems', []);

        // Cargamos los items seleccionados del carrito
        $this->cartItems = auth()->user()->cart->items()->whereIn('id', $this->selectedItems)->get();

        $this->updateTotal();
    }

    // Método para calcular el total de los productos seleccionados
    public function updateTotal()
    {
        $total = 0;

        foreach ($this->cartItems as $item) {
            if (in_array($item->id, $this->selectedItems)) {
                $total += $item->quantity * $item->product->price;
            }
        }

        $this->totalPrice = $total;
    }

    public function confirmOrder()
    {
        DB::beginTransaction();

        $total = $this->totalPrice;

        $order = Order::create([
            'user_id' => auth()->id(),
            'total' => $total,
            'status' => 'pendiente',
        ]);

        foreach ($this->cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'size_id' => $item->size_id,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
            ]);

            // Descontar stock directamente desde la tabla productsize
            DB::table('product_size')
                ->where('product_id', $item->product_id)
                ->where('size_id', $item->size_id)
                ->decrement('stock', $item->quantity);

            // Eliminar del carrito
            $item->delete();
        }

        DB::commit();

        $this->dispatch('orderConfirmed');

        session()->flash('success', '¡Pedido confirmado con éxito!');
        return redirect()->route('user.index');
    }

    public function cancelOrder()
    {
        return redirect()->route('user.carrito');
    }

    public function render()
    {
        return view('livewire.order-confirmation');
    }
}
