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
        'delivery_address',
    ];

    // casteo para fechas y decimales
    protected $casts = [
        'purchase_datetime' => 'datetime',
        'subtotal' => 'decimal:2',
        'taxes' => 'decimal:2',
        'shipment_value' => 'decimal:2',
        'total' => 'decimal:2',
        'delyvery_adress' => 'string|max:100',
    ];


    // aqui defino esta relacion para acceder al usuario desde la compra
    public function user()
    {
        return $this->hasOneThrough(User::class, Client::class, 'id_client', 'id_user', 'id_client', 'id_user');
    }


    public function shipment()
    {
        return $this->hasOne(Shipment::class, 'id_purchase', 'id_purchase');
    }

    public function details()
    {
        return $this->hasMany(PurchaseDetail::class, 'id_purchase', 'id_purchase');
    }

    public function getTotalItemsAttribute()
    {
        return $this->details->sum('quantity');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'id_client', 'id_user'); 
    }
}