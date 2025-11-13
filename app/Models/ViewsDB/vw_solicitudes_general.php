<?php

namespace App\Models\ViewsDB;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class vw_solicitudes_general extends Model
{
    public $timestamps = false;
    protected $table = 'vw_solicitudes';

   protected $fillable = [
        'Id_Invitados',
        'NombreInvitado',
        'ApellidoPInvitado',
        'ApellidoMInvitado',
        'CorreoInvitado',
        'TipoTransporte',
        'TipoVehiculo',
        'MarcaVehiculo',
        'ModeloVehiculo',
        'ColorVehiculo',
        'PlacasVehiculo',
        'TipoInvitado',
        'Edificio',
        'CantVis',
        'Acompanantes',
        'MotivoVisit',
        'Fecha_Hora_Solicitada',
        'Estado',
        'MotivoRechazo',
        'FK_Id_UserAccion',
        'Num_Iden',
        'Puesto',
        'Area',
        'NombreAccion',
        'ApellidoPAccion',
        'ApellidoMAccion',
        'CorreoAccion',
        'Solicitud_Creada_En',
        'Solicitud_Actualizada_En'
    ];
    
    protected $primaryKey = 'Id_Solicitud';
    public $incrementing = false;
}
