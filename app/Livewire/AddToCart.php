<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Cart;
use App\Models\CartItem;

class AddToCart extends Component
{
    public $product;
    public $sizeId;
    public $quantity = 1;

    public $message = null;
    public $messageType = 'success'; // 'success' o 'error'

    public function addToCart()
    {
        try {
            $user = auth()->user();

            if (!$user) {
                $this->message = 'Debes iniciar sesión para añadir productos al carrito.';
                $this->messageType = 'error';
                return;
            }

            if (!$this->product) {
                $this->message = 'Producto no válido.';
                $this->messageType = 'error';
                return;
            }

            if (!$this->sizeId) {
                $this->message = 'Por favor selecciona una talla.';
                $this->messageType = 'error';
                return;
            }


            $cart = Cart::firstOrCreate(['user_id' => $user->id]);

            $cartItem = CartItem::where('cart_id', $cart->id)
                ->where('product_id', $this->product->id)
                ->where('size_id', $this->sizeId)
                ->first();

            if ($cartItem) {
                $cartItem->quantity += $this->quantity;
                $cartItem->save();
            } else {
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
            $this->message = 'Error: ' . $e->getMessage();
            $this->messageType = 'error';
        }

    }


    public function render()
    {
        return view('livewire.add-to-cart');
    }
}


