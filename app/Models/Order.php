<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use App\Models\OrderItem;

class Order extends Model
{
    use HasFactory;

    // Campos que se pueden asignar masivamente para crear o actualizar un pedido
    protected $fillable = [
        'user_id',              // ID del usuario que realizó el pedido
        'total',                // Total del pedido
        'status',               // Estado actual del pedido (ej. pendiente, enviado, cancelado)
    ];

    /**
     * Relación con el usuario que hizo el pedido.
     * Un pedido pertenece a un usuario.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relación con los ítems del pedido.
     * Un pedido tiene muchos ítems (productos con cantidad, talla, etc).
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Crea un pedido a partir de los items del carrito, actualiza stock y elimina los items del carrito.
     * Usa transacción para mantener la integridad.
     *
     * @param \App\Models\User $user
     * @param \Illuminate\Database\Eloquent\Collection $cartItems
     * @return self $order
     */
    public static function createFromCartItems($user, $cartItems)
    {
        return DB::transaction(function () use ($user, $cartItems) {

            // Calculamos el total con descuentos
            $total = 0;
            foreach ($cartItems as $item) {
                $price = $item->product->discount > 0
                    ? round($item->product->price * (1 - $item->product->discount / 100), 2)
                    : $item->product->price;

                $total += $price * $item->quantity;
            }

            // Creamos el pedido
            $order = self::create([
                'user_id' => $user->id,
                'total' => $total,
                'status' => 'pendiente',
            ]);

            // Creamos los order_items y actualizamos stock
            foreach ($cartItems as $item) {
                $price = $item->product->discount > 0
                    ? round($item->product->price * (1 - $item->product->discount / 100), 2)
                    : $item->product->price;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'size_id' => $item->size_id,
                    'quantity' => $item->quantity,
                    'price' => $price,
                ]);

                // Reducir stock en tabla pivot product_size
                DB::table('product_size')
                    ->where('product_id', $item->product_id)
                    ->where('size_id', $item->size_id)
                    ->decrement('stock', $item->quantity);

                // Eliminar item del carrito
                $item->delete();
            }

            return $order;
        });
    }

}
