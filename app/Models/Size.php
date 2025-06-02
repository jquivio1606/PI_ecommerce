<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Size extends Model
{

    protected $fillable = ['name'];

    /**
     * Relación muchos a muchos con productos.
     * Una talla puede estar asociada a muchos productos.
     * La tabla pivote incluye el campo 'stock' para el stock específico por talla-producto,
     * y mantiene timestamps para control de creación y actualización.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('stock')->withTimestamps();
    }
}
