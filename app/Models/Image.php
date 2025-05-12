<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = ['product_id', 'url'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');  // Cambia 'producto_id' por 'product_id'
    }


}

