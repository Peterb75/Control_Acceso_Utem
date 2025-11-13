<?php

namespace App\Models\Persona;

use Illuminate\Database\Eloquent\Model;
use App\Models\Vehiculo\Vehiculos; 

class Personas extends Model
{
    protected $table = 'Personas';
    protected $primaryKey = 'Id_Persona';
    public $timestamps = true;

    protected $fillable = [
        'Nombres',
        'ApellidoP',
        'ApellidoM',
        'Correo',
        'TipoTransporte',
        'TipoVehiculo'
    ];

    public function vehiculos()
    {
        return $this->hasMany(Vehiculos::class, 'FK_Id_Persona', 'Id_Persona');
    }
    
}
