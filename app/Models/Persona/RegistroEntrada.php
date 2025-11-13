<?php

namespace App\Models\Persona;

use Illuminate\Database\Eloquent\Model;

class RegistroEntrada extends Model
{
    protected $table = 'Registro_Entradas';
    protected $primaryKey = 'Id_Entrada';
    public $timestamps = true;

    protected $fillable = [
        'FK_Id_Persona',

    ];

    public function persona()
    {
        return $this->belongsTo('App\Models\Persona\Personas', 'FK_Id_Persona', 'Id_Persona');
    }
}
