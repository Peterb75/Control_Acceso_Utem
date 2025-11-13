<?php

namespace App\Models\ViewsDB;

use Illuminate\Database\Eloquent\Model;

class VW_User_Inactivos extends Model
{
    public $timestamps = false;
    protected $table = 'vw_user_inactivos';

    protected $fillable = [
        'Id_Users',
        'Nombres',
        'ApellidoP',
        'ApellidoM',
        'Correo',
        'TipoTransporte',
        'TipoVehiculo',
        'MarcaV',
        'ModeloV',
        'ColorV',
        'Placas',
        'TipoUsuarios',
        'NombrePuesto',
        'NombreArea',
        'Num_Iden',
        'Carrera',
        'Grupo',
        'Activo',
        'HoraFija_Entrada',
        'HoraFija_Salida',
        'Usuario_Created_At',
        'Usuario_Updated_At'
    ];

    protected $primaryKey = 'Id_Users';
    public $incrementing = false;
}
