<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    protected $table = 'tb_products';
    protected $primaryKey = 'id_product';
    public $incrementing = true;
    public $timestamps = false; // Considera habilitar timestamps

    protected $fillable = [
        'id_user',
        'id_category',
        'id_Qualification',
        'price',
        'product_name',
        'product_description',
        'stock',
        'weight_kg'
    ];

    // Relación con el productor
    public function producer(): BelongsTo
    {
        return $this->belongsTo(Producer::class, 'id_user', 'id_user');
    }

    // Relación con la categoría
    public function category(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'id_category', 'id_categorie');
    }

    // Relación con la calificación
    public function qualification(): BelongsTo
    {
        return $this->belongsTo(Qualification::class, 'id_Qualification', 'id_Qualification');
    }

    // Relación con productos de finca
    public function farmProducts(): HasMany
    {
        return $this->hasMany(FarmProduct::class, 'id_product', 'id_product');
    }

    // NUEVA RELACIÓN: Imágenes del producto
    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class, 'id_product', 'id_product');
    }

    // Accesor para obtener la imagen principal
    public function getMainImageAttribute()
    {
        return $this->images->firstWhere('is_primary', true) ?? $this->images->first();
    }
}