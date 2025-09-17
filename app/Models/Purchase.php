<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $table = 'tb_purchase';
    protected $primaryKey = 'id_purchase';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'id_client',
        'purchase_datetime',
        'subtotal',
        'taxes',
        'shipment_value',
        'total',
        'payment_method',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'id_client', 'id_user');
    }

    public function shipment()
    {
        return $this->hasOne(Shipment::class, 'id_purchase', 'id_purchase');
    }

     public function details()
    {
        return $this->hasMany(PurchaseDetail::class, 'id_purchase', 'id_purchase');
    }
}