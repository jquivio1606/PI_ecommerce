<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Especifica la tabla asociada en la base de datos
    protected $table = 'products';

    // Campos que se pueden asignar masivamente al crear o actualizar un producto
    protected $fillable = [
        'name',
        'description',
        'color',
        'gender',
        'style',
        'category',
        'price',
        'discount'
    ];

    /**
     * Relación uno a muchos con las imágenes del producto.
     * Un producto puede tener muchas imágenes.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    // app/Models/Product.php

    public function images()
    {
        return $this->hasMany(Image::class);
    }


    /**
     * Relación muchos a muchos con tallas (sizes).
     * Un producto puede tener varias tallas, y cada talla puede tener un stock asociado.
     * El método withPivot('stock') permite acceder al stock específico por talla desde la tabla pivote.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function sizes()
    {
        // withTimestamps() mantiene los timestamps en la tabla pivote
        return $this->belongsToMany(Size::class)->withPivot('stock')->withTimestamps();
    }
}
