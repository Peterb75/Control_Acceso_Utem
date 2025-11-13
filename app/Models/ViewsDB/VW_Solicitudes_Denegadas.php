<?php

namespace App\Models\ViewsDB;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class vw_solicitudes_denegadas extends Model
{
    use HasFactory;

    // No tiene timestamps porque es una vista
    public $timestamps = false;

    // Nombre exacto de la vista en la base de datos
    protected $table = 'vw_solicitudes_denegadas';

    // Clave primaria
    protected $primaryKey = 'Id_Solicitud';
    public $incrementing = false;

    // Campos disponibles para asignación masiva
    protected $fillable = [
        'Id_Solicitud',
        'FK_Id_Invitados',
        'FK_Id_Persona',
        'FK_TipoInvitado',
        'Tipo_Invitado',
        'Nombres',
        'ApellidoP',
        'ApellidoM',
        'Correo',
        'TipoTransporte',
        'Edificio',
        'CantVis',
        'MotivoVisit',
        'FechaSolicitada',
        'Estado',
        'TipoVehiculo',
        'MarcaV',
        'ModeloV',
        'ColorV',
        'Placas',
        'Acompanantes',
        'MotivoRechazo',
        'Num_Iden_Denegador',
        'NombreUsuarioDenegador',
        'ApellidoPaternoUsuarioDenegador',
        'Solicitud_Created_At',
        'Solicitud_Updated_At'
    ];
}
