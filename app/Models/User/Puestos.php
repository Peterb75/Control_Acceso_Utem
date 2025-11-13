<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class Puestos extends Model
{
    protected $table = 'Puestos';
    protected $primaryKey = 'Id_Puesto';
    public $timestamps = true;

    protected $fillable = [
        'NombrePuesto',
        'Descripcion'
    ];
}
