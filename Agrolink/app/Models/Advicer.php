<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Advicer extends Model
{
    protected $table = 'tb_advicer';
    protected $primaryKey = 'id_user';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id_user',
        'id_Qualification',
        'advice_tipe',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function qualification()
    {
        return $this->belongsTo(Qualification::class, 'id_Qualification', 'id_Qualification');
    }

    public function machines()
    {
        return $this->hasMany(Machine::class, 'id_advicer', 'id_user');
    }

    public function services()
    {
        return $this->hasMany(Service::class, 'id_adviser', 'id_user');
    }

    public function certificates()
    {
        return $this->hasMany(Certificate::class, 'id_user', 'id_user');
    }
}
