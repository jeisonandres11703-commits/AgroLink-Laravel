<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseDetail extends Model
{
    protected $table = 'tb_purchase_details';
    protected $primaryKey = 'id_detail';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'id_purchase',
        'id_product',
        'quantity',
        'unit_price',
        'subtotal',
    ];

    // Relación con el producto
    public function product()
    {
        return $this->belongsTo(Product::class, 'id_product', 'id_product');
    }
}