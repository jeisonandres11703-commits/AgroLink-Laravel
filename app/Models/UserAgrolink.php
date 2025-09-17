<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class UserAgrolink extends Model
{   
    use HasFactory, Notifiable;
    protected $table = 'tb_users';
    protected $primaryKey = 'id_user';
    
    protected $keyType = 'int';    
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'Name',
        'user_name',
        'user_password',
        'last_Name',
        'Phone',
        'Email',
        'City',
        'Department',
        'Direction',
        'ID_Card',
    ];

    // Relación con Client
    public function client()
    {
        return $this->hasOne(Client::class, 'id_user', 'id_user');
    }

    // Relación con Carrier
    public function carrier()
    {
        return $this->hasOne(Carrier::class, 'id_user', 'id_user');
    }

    // Puedes agregar más relaciones según tus necesidades
}
