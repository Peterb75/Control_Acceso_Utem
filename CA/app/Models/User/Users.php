<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    protected $table = 'Users';
    protected $primaryKey = 'Id_Users';
    public $timestamps = true;

    protected $fillable = [
        'FK_Id_Persona',
        'FK_TipoUsuario',
        'Num_Iden',
        'Password',
        'Carrera',
        'Grupo',
        'Activo',
        'HoraFija_Entrada',
        'HoraFija_Salida'
    ];

    public function Personas()
    {
        return $this->belongsTo('App\Models\Persona\Personas', 'FK_Id_Persona', 'Id_Persona');
    }

    public function TipoUsers()
    {
        return $this->belongsTo('App\Models\User\TipoUsers', 'FK_TipoUsuario', 'Id_TipoUsuario');
    }

}
