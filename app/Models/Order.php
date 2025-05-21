<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    // Campos que se pueden asignar masivamente para crear o actualizar una orden
    protected $fillable = [
        'user_id',  // ID del usuario que realizó el pedido
        'total',    // Total del pedido
        'status',   // Estado actual del pedido (ej. pendiente, enviado, cancelado)
    ];

    /**
     * Relación con el usuario que hizo el pedido.
     * Una orden pertenece a un usuario.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relación con los ítems del pedido.
     * Una orden tiene muchos ítems (productos con cantidad, talla, etc).
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
