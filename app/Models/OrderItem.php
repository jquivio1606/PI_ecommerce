<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderItem extends Model
{
    use HasFactory;

    // Campos asignables masivamente para un ítem del pedido
    protected $fillable = [
        'order_id',         // ID del pedido al que pertenece este ítem
        'product_id',       // ID del producto comprado
        'size_id',          // ID de la talla seleccionada del producto
        'quantity',         // Cantidad de este producto en el pedido
        'price',            // Precio unitario del producto en el momento del pedido
    ];

    /**
     * Relación que conecta este ítem con su pedido (Order).
     * Un ítem pertenece a un pedido.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Relación que conecta este ítem con el producto comprado.
     * Un ítem pertenece a un producto.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Relación que conecta este ítem con la talla seleccionada.
     * Un ítem pertenece a una talla.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function size()
    {
        return $this->belongsTo(Size::class);
    }
}
