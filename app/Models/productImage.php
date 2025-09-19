<?php
// app/Models/ProductImage.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductImage extends Model
{
    protected $table = 'tb_product_images';
    protected $primaryKey = 'id_image';
    public $incrementing = true;
    public $timestamps = false; // Considera habilitar timestamps

    protected $fillable = [
        'id_product',
        'file_path',
        'file_type',
        'is_primary',
        'uploaded_at'
    ];

    // Relación con el producto
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'id_product', 'id_product');
    }

    // Accesor para la URL completa de la imagen
    public function getImageUrlAttribute()
    {
        if ($this->file_path) {
            return asset('storage/' . $this->file_path);
        }
        
        return asset('images/placeholder.jpg');
    }
}