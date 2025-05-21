<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Cart;
use App\Models\CartItem;

class AddToCart extends Component
{
    // Variables públicas que vienen del componente Livewire (enlace con el frontend)
    public $product;
    public $sizeId;
    public $quantity = 1;

    // Mensajes para el usuario después de intentar añadir al carrito
    public $message = null;
    public $messageType = 'success'; // puede ser 'success' o 'error'

    /**
     * Añade un producto al carrito del usuario autenticado.
     */
    public function addToCart()
    {
        try {
            $user = auth()->user(); // Obtener el usuario autenticado

            // Validar si hay sesión iniciada
            if (!$user) {
                $this->message = 'Debes iniciar sesión para añadir productos al carrito.';
                $this->messageType = 'error';
                return;
            }

            // Validar que el producto exista
            if (!$this->product) {
                $this->message = 'Producto no válido.';
                $this->messageType = 'error';
                return;
            }

            // Validar que haya una talla seleccionada
            if (!$this->sizeId) {
                $this->message = 'Por favor selecciona una talla.';
                $this->messageType = 'error';
                return;
            }

            // Buscar o crear un carrito para el usuario
            $cart = Cart::firstOrCreate(['user_id' => $user->id]);

            // Buscar si ya existe el mismo producto con la misma talla en el carrito
            $cartItem = CartItem::where('cart_id', $cart->id)
                ->where('product_id', $this->product->id)
                ->where('size_id', $this->sizeId)
                ->first();

            if ($cartItem) {
                // Si ya existe, solo se incrementa la cantidad
                $cartItem->quantity += $this->quantity;
                $cartItem->save();
            } else {
                // Si no existe, se crea un nuevo item en el carrito
                CartItem::create([
                    'cart_id' => $cart->id,
                    'product_id' => $this->product->id,
                    'size_id' => $this->sizeId,
                    'quantity' => $this->quantity,
                ]);
            }

            $this->message = 'Producto añadido al carrito.';
            $this->messageType = 'success';

        } catch (\Exception $e) {
            // Captura cualquier error inesperado y muestra el mensaje
            $this->message = 'Error: ' . $e->getMessage();
            $this->messageType = 'error';
        }
    }

    /**
     * Renderiza la vista del componente Livewire.
     */
    public function render()
    {
        return view('livewire.add-to-cart');
    }
}
