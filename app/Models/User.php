<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $table = 'tb_users';
    protected $primaryKey = 'id_user';
    
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

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function client()
    {
        return $this->hasOne(Client::class, 'id_user', 'id_user');
    }

    // Relación con Carrier
    public function carrier()
    {
        return $this->hasOne(Carrier::class, 'id_user', 'id_user');
    }

    public function getAuthPassword()
    {
        return $this->user_password;
    }


}
