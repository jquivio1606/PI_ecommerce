<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    use HasFactory;
    protected $table = 'products';
    protected $fillable = ['name', 'description', 'color', 'gender', 'style', 'size', 'category', 'stock', 'price'];

    public function images()
    {
        return $this->hasMany(Image::class, 'product_id');  // Cambia 'producto_id' por 'product_id'
    }

    public function sizes()
    {
        return $this->belongsToMany(Size::class)->withPivot('stock')->withTimestamps();
    }

}


