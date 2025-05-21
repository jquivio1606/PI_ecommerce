<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    // Campos asignables masivamente para crear o actualizar un item en el carrito
    protected $fillable = ['cart_id', 'product_id', 'size_id', 'quantity'];

    /**
     * Relación inversa con el carrito.
     * Cada item pertenece a un carrito específico.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cart()
    {
        return $this->belongsTo(Cart::class); // El item pertenece a un carrito
    }

    /**
     * Relación inversa con el producto.
     * Cada item está relacionado con un producto específico.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class); // El item pertenece a un producto
    }

    /**
     * Relación inversa con la talla.
     * Cada item tiene asociada una talla específica.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function size()
    {
        return $this->belongsTo(Size::class); // El item tiene una talla asociada
    }
}
