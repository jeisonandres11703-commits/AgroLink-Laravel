<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FarmProduct extends Model
{
    protected $table = 'tb_farm_products';
    protected $primaryKey = 'id_farm_product';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'id_farm',
        'id_product',
        'production_quantity',
        'harvest_date',
    ];

    public function farm()
    {
        return $this->belongsTo(Farm::class, 'id_farm', 'id_farm');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_product', 'id_product');
    }
}
