<?php

namespace App\Livewire;

use Livewire\Component;

class ShowCart extends Component
{
    public $cartItems;               // Items que hay en el carrito del usuario
    public $totalPrice = 0;          // Precio total de los productos seleccionados
    public $selectedItems = [];      // IDs de los productos seleccionados para compra
    public $itemToDelete = null;     // ID del producto a eliminar (si se usa)
    public $message = null;          // Mensaje de notificación para el usuario
    public $messageType = 'success'; // Tipo de mensaje ('success', 'error', 'warning')
    public $showMessage = false;     // Controla si se muestra el mensaje

    /**
     * Se ejecuta al cargar el componente.
     * Obtiene el carrito del usuario autenticado o lo crea si no existe.
     * Inicializa los items y calcula el total.
     */
    public function mount()
    {
        $user = auth()->user();
        $cart = $user->cart;

        // Si el usuario no tiene carrito, se crea uno vacío
        if (!$cart) {
            $cart = $user->cart()->create();
        }

        // Carga los items del carrito con la relación de producto e imágenes
        $this->cartItems = $cart->items()->with('product.images')->get();

        // Si el carrito está vacío, mostramos mensaje de advertencia
        if ($this->cartItems->isEmpty()) {
            $this->setMessage('Todavía no hay productos en el carrito', 'warning');
        }

        // Calcula el total de productos seleccionados
        $this->updateTotal();
    }


    /**
     * Método que se llama cuando el usuario selecciona o deselecciona un producto.
     * Añade o elimina el ID del producto del array selectedItems.
     *
     * @param int $itemId ID del item seleccionado o deseleccionado
     */
    public function itemSelection($itemId)
    {
        // Si el item ya estaba seleccionado, lo quitamos
        if (in_array($itemId, $this->selectedItems)) {
            $this->selectedItems = array_filter($this->selectedItems, function ($id) use ($itemId) {
                return $id != $itemId;
            });
        } else {
            // Si no estaba seleccionado, lo añadimos
            $this->selectedItems[] = $itemId;
        }

        // Actualizamos el total teniendo en cuenta los productos seleccionados
        $this->updateTotal();
    }

    /**
     * Calcula el precio total sumando los productos seleccionados.
     * Multiplica la cantidad por el precio de cada producto.
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
     * Confirma y elimina un producto del carrito.
     *
     * @param int $itemId ID del item a eliminar
     */
    public function confirmDeletion($itemId)
    {
        $cartItem = auth()->user()->cart->items()->find($itemId);
        if ($cartItem) {
            $cartItem->delete();
            // Actualizamos la lista de items del carrito y el total
            $this->cartItems = auth()->user()->cart->items;
            $this->updateTotal();
            $this->setMessage('Producto eliminado del carrito', 'success');
        }

        // Si el carrito queda vacío, mostramos mensaje de advertencia
        if ($this->cartItems->isEmpty()) {
            $this->setMessage('Todavía no hay productos en el carrito', 'warning');
        }
    }

    /**
     * Actualiza la cantidad y talla de un producto en el carrito.
     *
     * @param int $itemId ID del item a actualizar
     * @param int $quantity Nueva cantidad
     * @param int $size ID de la talla seleccionada
     */
    public function updateCartItem($itemId, $quantity, $size)
    {
        $cartItem = auth()->user()->cart->items()->find($itemId);
        if ($cartItem) {
            $cartItem->quantity = $quantity;
            $cartItem->size_id = $size;
            $cartItem->save();

            // Refrescamos los items y el total para reflejar los cambios
            $this->cartItems = auth()->user()->cart->items;
            $this->updateTotal();
            $this->setMessage('Producto actualizado', 'success');
        } else {
            $this->setMessage('No se ha podido actualizar el producto', 'error');
        }
    }

    /**
     * Configura el mensaje que se mostrará al usuario.
     *
     * @param string $message Texto del mensaje
     * @param string $messageType Tipo de mensaje ('success', 'error', 'warning')
     */
    public function setMessage($message, $messageType = 'success')
    {
        $this->message = $message;
        $this->messageType = $messageType;
        $this->showMessage = true;
    }

    /**
     * Método que crea el pedido con los productos seleccionados.
     * Si no hay productos seleccionados, muestra mensaje de advertencia.
     */
    public function makeOrder()
    {
        if (empty($this->selectedItems)) {
            $this->setMessage('Debes seleccionar al menos un producto', 'warning');
            return;
        }

        // Guardamos en sesión los IDs de los productos seleccionados para usar en la confirmación
        session()->put('selectedItems', $this->selectedItems);

        // Redirigimos a la ruta de confirmación de pedido
        return redirect()->route('user.orderConfirmation');
    }

    /**
     * Renderiza la vista correspondiente al carrito.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.show-cart');
    }
}
