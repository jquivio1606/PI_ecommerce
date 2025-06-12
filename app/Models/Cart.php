<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    // Campos que pueden asignarse masivamente para crear o actualizar un carrito
    protected $fillable = ['user_id'];

    /**
     * Relación uno a muchos con los items del carrito.
     * Un carrito puede tener muchos items (productos añadidos).
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items()
    {
        return $this->hasMany(CartItem::class); // Cada carrito tiene muchos cart items relacionados
    }

    /**
     * Relación inversa uno a uno con el usuario.
     * Cada carrito pertenece a un usuario específico.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class); // Relación con el usuario dueño del carrito
    }


    /**
     * Añade un producto al carrito, sumando cantidad si ya existe.
     *
     * @param int $productId
     * @param int $sizeId
     * @param int $quantity
     * @return void
     */
    public function addProduct(int $productId, int $sizeId, int $quantity = 1)
    {
        $cartItem = $this->items()
            ->where('product_id', $productId)
            ->where('size_id', $sizeId)
            ->first();

        if ($cartItem) {
            $cartItem->quantity += $quantity;
            $cartItem->save();
        } else {
            $this->items()->create([
                'product_id' => $productId,
                'size_id' => $sizeId,
                'quantity' => $quantity,
            ]);
        }
    }

}
