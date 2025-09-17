<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'tb_products';
    protected $primaryKey = 'id_product';
    public $incrementing = true;
    public $timestamps = false;

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

    public function producer()
    {
        return $this->belongsTo(Producer::class, 'id_user', 'id_user');
    }

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'id_category', 'id_categorie');
    }

    public function qualification()
    {
        return $this->belongsTo(Qualification::class, 'id_Qualification', 'id_Qualification');
    }

    public function farmProducts()
    {
        return $this->hasMany(FarmProduct::class, 'id_product', 'id_product');
    }
}