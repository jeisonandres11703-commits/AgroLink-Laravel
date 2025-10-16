<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Farm extends Model
{
    protected $table = 'tb_farms';
    protected $primaryKey = 'id_farm';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'id_user',
        'farm_name',
        'farm_direction',
        'BPA_certificate',
        'MIRFE_certificate',
        'MIPE_certificate',
        'ICA_Registry',
    ];

    public function producer()
    {
        return $this->belongsTo(Producer::class, 'id_user', 'id_user');
    }

    public function farmProducts()
    {
        return $this->hasMany(FarmProduct::class, 'id_farm', 'id_farm');
    }
}
