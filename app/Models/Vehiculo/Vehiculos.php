<?php

namespace App\Models\Vehiculo;

use Illuminate\Database\Eloquent\Model;

class Vehiculos extends Model
{
    protected $table = 'Vehiculos';
    protected $primaryKey = 'Id_Vehicular';
    public $timestamps = true;

    protected $fillable = [
        'FK_Id_Persona',
        'FK_Id_DatoV',
    ];

    public function persona()
    {
        return $this->belongsTo('App\Models\Persona\Personas', 'FK_Id_Persona', 'Id_Persona');
    }

    public function datoVehiculo()
    {
        return $this->hasOne(DatoVehiculos::class, 'Id_DatoV', 'FK_Id_DatoV');
    }
}
