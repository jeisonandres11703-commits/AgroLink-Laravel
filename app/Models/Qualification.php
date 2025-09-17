<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Qualification extends Model
{
    protected $table = 'tb_Qualification';
    protected $primaryKey = 'id_Qualification';
    public $incrementing = true;
    public $timestamps = false;

    // Relación con clientes
    public function clients()
    {
        return $this->hasMany(Client::class, 'id_Qualification', 'id_Qualification');
    }

    // Relación con transportistas
    public function carriers()
    {
        return $this->hasMany(Carrier::class, 'id_Qualification', 'id_Qualification');
    }

    // Relación con productores
    public function producers()
    {
        return $this->hasMany(Producer::class, 'id_Qualification', 'id_Qualification');
    }

    // Relación con asesores
    public function advicers()
    {
        return $this->hasMany(Advicer::class, 'id_Qualification', 'id_Qualification');
    }
}

