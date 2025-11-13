<?php

namespace App\Models\ViewsDB;

use Illuminate\Database\Eloquent\Model;

class VW_SolInvitados_Aceptados extends Model
{
    public $timestamps = false;
    protected $table = 'vw_solicitudes_aceptadas';

    protected $fillable = [
        'Id_Aceptado',
        'FK_Id_Solicitud',
        'NombrePersonaInvitado',
        'ApellidoPersonaInvitado',
        'FK_Id_Invitados',
        'Tipo_Invitado',
        'TipoTransporte',      
        'TipoVehiculo',
        'Edificio',
        'CantVis',
        'FechaSolicitada',
        'Horario_Entrada',
        'MarcaInvitado',
        'ModeloInvitado',
        'ColorInvitado',
        'PlacasInvitado',
        'Num_Iden',
        'NombreUsuarioAceptado',
        'Appellido_Paterno_UsuarioAceptado',
        'FK_Id_Puesto',
        'FK_Id_Area',
        'FechaCreacionAceptado',
        'FechaActualizacionAceptado'
    ];

    protected $primaryKey = 'Id_Aceptado';
    public $incrementing = false;
}
