<?php

namespace App\Models\ViewsDB;
    
use Illuminate\Database\Eloquent\Model;

class VW_SolInvitados_Pendientes extends Model
{
    // Indicar que el modelo no debe gestionar timestamps automáticamente
    public $timestamps = false;

    // Indicar el nombre de la vista
    protected $table = 'VW_Solicitudes_Pendientes';

    // Definir los campos que se pueden rellenar
    protected $fillable = [
        'Id_Solicitud',
        'FK_Id_Invitados',
        'FK_Id_Persona',
        'FK_TipoInvitado',
        'Edificio',
        'CantVis',
        'MotivoVisit',
        'FechaSolicitada',
        'Estado',
        'Solicitud_Created_At',
        'Solicitud_Updated_At'
    ];

    // Si tienes una clave primaria diferente a 'id'
    protected $primaryKey = 'Id_Solicitud';

    // Si la clave primaria no es auto-incremental
    public $incrementing = false;

    // Si la clave primaria no es un integer
    protected $keyType = 'string';
}
