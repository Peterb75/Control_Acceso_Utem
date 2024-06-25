<?php

namespace App\Models\Vehiculo;

use Illuminate\Database\Eloquent\Model;

class DatoVehiculos extends Model
{
    protected $table = 'DatoV';
    protected $primaryKey = 'Id_DatoV';
    public $timestamps = false;

    protected $fillable = [
        'MarcaV',
        'ModeloV',
        'ColorV',
        'Placas',
    ];
}
