<?php

namespace App\Livewire;

use Livewire\Component;

class AddToCart extends Component
{
    // Variables públicas que vienen del frontend (se pueden enlazar con wire:model)
    public $product;     // Producto que se quiere añadir al carrito (objeto Product)
    public $sizeId;       // ID de la talla seleccionada
    public $quantity = 1; // Cantidad a añadir, por defecto 1

    // Variables para mostrar mensajes de feedback al usuario
    public $message = null;           // Texto del mensaje
    public $messageType = 'success'; // Tipo de mensaje ('success' o 'error')

    /**
     * Método que se ejecuta cuando el usuario quiere añadir un producto al carrito.
     */
    public function addToCart()
    {
        // Obtener el usuario autenticado
        $user = auth()->user();

        // Validar que el usuario esté logueado
        if (!$user) {
            $this->message = 'Debes iniciar sesión para añadir productos al carrito.';
            $this->messageType = 'error';
            return; // Detener ejecución si no hay usuario
        }

        // Validar que el producto sea válido (exista)
        if (!$this->product) {
            $this->message = 'Producto no válido.';
            $this->messageType = 'error';
            return;
        }

        // Validar que se haya seleccionado una talla
        if (!$this->sizeId) {
            $this->message = 'Por favor selecciona una talla.';
            $this->messageType = 'error';
            return;
        }

        try {
            // Obtener o crear el carrito asociado al usuario
            $cart = $user->getOrCreateCart();

            // Añadir el producto con la talla y cantidad indicada al carrito
            $cart->addProduct($this->product->id, $this->sizeId, $this->quantity);

            // Mensaje de éxito para el usuario
            $this->message = 'Producto añadido al carrito.';
            $this->messageType = 'success';

        } catch (\Exception $e) {
            // Capturar cualquier error y mostrar mensaje de error
            $this->message = 'Error: ' . $e->getMessage();
            $this->messageType = 'error';
        }
    }

    /**
     * Renderiza la vista del componente.
     * Esta vista estará en resources/views/livewire/add-to-cart.blade.php
     */
    public function render()
    {
        return view('livewire.add-to-cart');
    }
}

