<?php

namespace App\Models\Persona;

use Illuminate\Database\Eloquent\Model;

class RegistroSalida extends Model
{
    protected $table = 'Registro_Salida';
    protected $primaryKey = 'Id_Salida';
    public $timestamps = false;

    protected $fillable = [
        'FK_Id_Persona',
        'Salida',
    ];

    public function persona()
    {
        return $this->belongsTo('App\Models\Persona\Personas', 'FK_Id_Persona', 'Id_Persona');
    }

}
