<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    // Campos que se pueden asignar masivamente (fillable)
    protected $fillable = ['product_id', 'url'];

    /**
     * Relación inversa con el producto.
     * Cada imagen pertenece a un producto específico.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        // Se indica que esta imagen pertenece a un producto a través de 'product_id'
        return $this->belongsTo(Product::class, 'product_id');
    }
}
