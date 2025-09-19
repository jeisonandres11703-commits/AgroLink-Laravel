<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Carrier extends Model
{
    protected $table = 'tb_carrier';
    protected $primaryKey = 'id_user';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id_user',
        'id_Qualification',
        'delivery_zones',
    ];

    public function shipments()
    {
        return $this->hasMany(Shipment::class, 'id_carrier', 'id_user');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function qualification()
    {
        return $this->belongsTo(Qualification::class, 'id_Qualification', 'id_Qualification');
    }
}
