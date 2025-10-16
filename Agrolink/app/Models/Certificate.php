<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    protected $table = 'tb_Certificates';
    protected $primaryKey = 'id_certificate';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'id_user',
        'certificate_type',
        'cert_description',
        'expedition_date',
    ];

    public function advicer()
    {
        return $this->belongsTo(Advicer::class, 'id_user', 'id_user');
    }
}
