<?php

namespace App\Models\Persona;

use Illuminate\Database\Eloquent\Model;

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
    ];

}
