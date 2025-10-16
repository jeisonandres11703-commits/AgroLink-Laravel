<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $table = 'tb_services';
    protected $primaryKey = 'id_service';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'id_adviser',
        'description',
        'status',
    ];

    public function advicer()
    {
        return $this->belongsTo(Advicer::class, 'id_adviser', 'id_user');
    }
}