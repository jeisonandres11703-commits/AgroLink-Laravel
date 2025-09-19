<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $table = 'tb_client';
    protected $primaryKey = 'id_user';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id_user',
        'id_Qualification',
        'preferences',
    ];

    public function purchases()
    {
        return $this->hasMany(Purchase::class, 'id_user', 'id_user');
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
