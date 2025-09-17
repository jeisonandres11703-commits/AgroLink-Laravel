<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producer extends Model
{
    protected $table = 'tb_producers';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id_user',
        'id_Qualification',
        'cultivation_type',
    ];

    public function user()
    {
        return $this->belongsTo(UserAgrolink::class, 'id_user', 'id_user');
    }

    public function qualification()
    {
        return $this->belongsTo(Qualification::class, 'id_Qualification', 'id_Qualification');
    }

    public function farms()
    {
        return $this->hasMany(Farm::class, 'id_user', 'id_user');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'id_user', 'id_user');
    }
}
