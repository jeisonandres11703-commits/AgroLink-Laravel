<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    protected $table = 'tb_shipments'; 
    protected $primaryKey = 'id_shipment'; 
    public $incrementing = true;
    public $timestamps = false; 
    protected $fillable = [
        'id_purchase',
        'id_carrier',
        'shipment_status',
        'departure_date',
        'delivery_davte',
        'tracking_number',
    ];

    // Relaciones (opcional, si tienes los modelos)
    public function purchase()
    {
        return $this->belongsTo(Purchase::class, 'id_purchase', 'id_purchase');
    }

    public function carrier()
    {
        return $this->belongsTo(Carrier::class, 'id_carrier', 'id_user');
    }

    public function client()
    {
        return $this->purchase ? $this->purchase->client() : null;
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'id_vehicle', 'id_vehicle');
    }
}

