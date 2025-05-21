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
     * Relación inversa uno a muchos con el usuario.
     * Cada carrito pertenece a un usuario específico.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class); // Relación con el usuario dueño del carrito
    }
}
