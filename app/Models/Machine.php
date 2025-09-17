<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Machine extends Model
{
    protected $table = 'tb_machines';
    protected $primaryKey = 'id_machine';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'id_advicer',
        'machine_type',
        'property_document',
        'model',
        'National_Registry_of_Agricultural_Machinery_RNMA',
        'Machinery_Registration_Card',
    ];

    public function advicer()
    {
        return $this->belongsTo(Advicer::class, 'id_advicer', 'id_user');
    }
}
