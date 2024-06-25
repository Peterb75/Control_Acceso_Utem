<?php

namespace App\Models\Vehiculo;

use Illuminate\Database\Eloquent\Model;

class Vehiculos extends Model
{
    protected $table = 'Vehiculos';
    protected $primaryKey = 'Id_Vehicular';
    public $timestamps = false;

    protected $fillable = [
        'FK_Id_Persona',
        'FK_Id_DatoV',
    ];

    public function persona()
    {
        return $this->belongsTo('App\Models\Persona\Personas', 'FK_Id_Persona', 'Id_Persona');
    }

    public function datov()
    {
        return $this->belongsTo('App\Models\Vehiculo\DatoVehiculos', 'FK_Id_DatoV', 'Id_DatoV');
    }


}
