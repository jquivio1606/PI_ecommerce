<?php

namespace App\Livewire;

use Livewire\Component;


class ShowCart extends Component
{
    public $cartItems;
    public $totalPrice = 0;
    public $selectedItems = [];
    public $itemToDelete = null;
    public $message = null;
    public $messageType = 'success'; // 'success', 'error' o 'warning'
    public $showMessage = false;


    public function mount()
    {
        $user = auth()->user();
        $cart = $user->cart;
        $this->showMessage = false;

        if (!$cart) {
            // Si no existe carrito, creamos uno vacío para el usuario
            $cart = $user->cart()->create();
        }

        $this->cartItems = $cart->items;

        if ($this->cartItems->isEmpty()) {
            $this->setMessage('Todavía no hay productos en el carrito', 'warning');
        }

        $this->updateTotal();
    }

    // Método que se llama cuando se selecciona o deselecciona un producto
    public function itemSelection($itemId)
    {
        // Si el producto ya estaba seleccionado, lo quitamos
        if (in_array($itemId, $this->selectedItems)) {
            $this->selectedItems = array_filter($this->selectedItems, function ($id) use ($itemId) {
                return $id != $itemId;
            });
        } else {
            // Si no estaba, lo añadimos
            $this->selectedItems[] = $itemId;
        }

        // Actualizamos el total con los productos seleccionados
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

    public function confirmDeletion($itemId)
    {
        $cartItem = auth()->user()->cart->items()->find($itemId);
        if ($cartItem) {
            $cartItem->delete();
            $this->cartItems = auth()->user()->cart->items;  // Reactualizamos los items del carrito
            $this->updateTotal();
            $this->setMessage('Producto eliminado del carrito', 'success');
        }

        if ($this->cartItems->isEmpty()) {
            $this->setMessage('Todavía no hay productos en el carrito', 'warning');
        }
    }

    public function updateCartItem($itemId, $quantity, $size)
    {
        $cartItem = auth()->user()->cart->items()->find($itemId);
        if ($cartItem) {
            $cartItem->quantity = $quantity;
            $cartItem->size_id = $size;
            $cartItem->save();
            $this->cartItems = auth()->user()->cart->items;  // Reactualizamos los items del carrito
            $this->updateTotal();
            $this->setMessage('Producto actualizado', 'success');
        } else {
            $this->setMessage('No se ha podido actualizar el producto', 'error');
        }
    }

    public function setMessage($message, $messageType = 'success')
    {
        $this->message = $message;
        $this->messageType = $messageType;
        $this->showMessage = true;
    }

    public function makeOrder()
    {
        if (empty($this->selectedItems)) {
            $this->setMessage('Debes seleccionar al menos un producto', 'warning');
            return;
        }

        // Guardamos los productos seleccionados en la sesión
        session()->put('selectedItems', $this->selectedItems);

        // Redirige a la vista de confirmación
        return redirect()->route('user.orderConfirmation');
    }

    public function render()
    {
        return view('livewire.show-cart');
    }
}
