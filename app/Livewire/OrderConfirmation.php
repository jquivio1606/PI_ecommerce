<?php

namespace App\Livewire;

use Illuminate\Support\Facades\DB;
use Livewire\Component;
use App\Models\OrderItem;
use App\Models\Order;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailPedidos;

class OrderConfirmation extends Component
{
    public $selectedItems = []; // IDs de los productos seleccionados por el usuario desde el carrito
    public $cartItems;          // Instancias completas de los productos seleccionados
    public $totalPrice = 0;     // Precio total de los productos seleccionados


    /**
     * Se ejecuta al cargar el componente.
     * Carga los productos seleccionados desde la sesión y calcula el total.
     */
    public function mount()
    {
        // Recuperamos los IDs de los productos seleccionados desde la sesión
        $this->selectedItems = session('selectedItems', []);

        // Cargamos los productos seleccionados del carrito del usuario autenticado
        $this->cartItems = auth()->user()
            ->cart
            ->items()
            ->whereIn('id', $this->selectedItems)
            ->get();

        // Calculamos el total del pedido
        $this->updateTotal();
    }

    /**
     * Calcula el precio total de los productos seleccionados.
     */
    public function updateTotal()
    {
        $total = 0; // Inicializamos el total en 0

        foreach ($this->cartItems as $item) {
            // Verificamos si el ítem está entre los seleccionados
            if (in_array($item->id, $this->selectedItems)) {

                // Precio base del producto (sin descuento)
                $price = $item->product->price;

                // Si el producto tiene un descuento, se aplica
                if ($item->product->discount && $item->product->discount > 0) {
                    $discount = $item->product->discount;
                    $price = $price - ($price * $discount / 100); // Precio con descuento aplicado
                }

                // Sumamos al total la cantidad multiplicada por el precio (con o sin descuento)
                $total += $item->quantity * $price;
            }
        }

        // Asignamos el total calculado a la propiedad del componente
        $this->totalPrice = $total;
    }



    /**
     * Confirma el pedido:
     * - Crea el registro en la tabla orders
     * - Crea los registros en la tabla order_items
     * - Descuenta el stock correspondiente en la tabla product_size
     * - Elimina los items del carrito
     * - Envía un correo al administrador
     */
    public function confirmOrder()
    {
        DB::beginTransaction(); // Inicia transacción para asegurar que todo se guarda correctamente

        $total = $this->totalPrice;

        // Crear pedido en la base de datos
        $order = Order::create([
            'user_id' => auth()->id(),
            'total' => $total,
            'status' => 'pendiente',
        ]);

        // Crear items del pedido y actualizar stock
        foreach ($this->cartItems as $item) {
            // Calcula el precio con descuento si aplica
            $price = $item->product->price;
            if ($item->product->discount && $item->product->discount > 0) {
                $discount = $item->product->discount;
                $price = $price - ($price * $discount / 100);
            }

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'size_id' => $item->size_id,
                'quantity' => $item->quantity,
                'price' => $price,  // Guardamos el precio con descuento aquí
            ]);

            // Reducir el stock desde la tabla intermedia product_size
            DB::table('product_size')
                ->where('product_id', $item->product_id)
                ->where('size_id', $item->size_id)
                ->decrement('stock', $item->quantity);

            // Eliminar el ítem del carrito
            $item->delete();
        }

        DB::commit(); // Confirma todos los cambios si no hubo errores

        // Enviar correo de confirmación al administrador
        Mail::to('juditquirosviolero@gmail.com')->send(new EmailPedidos($order));

        // Mensaje de éxito para el usuario
        session()->flash('success', '¡Pedido confirmado con éxito!');

        // Redirigir al inicio del usuario
        return redirect()->route('user.index');
    }

    /**
     * Cancela el proceso de confirmación y redirige de nuevo al carrito.
     */
    public function cancelOrder()
    {
        return redirect()->route('user.cart');
    }

    /**
     * Renderiza la vista de confirmación del pedido.
     */
    public function render()
    {
        return view('livewire.order-confirmation');
    }
}
