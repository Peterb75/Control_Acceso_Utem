<?php

namespace App\Models\Invitado;

use Illuminate\Database\Eloquent\Model;
use App\Models\Persona\Personas;
use App\Models\Invitado\TipoInvitado;
use App\Models\Invitado\SolicitudInvitado;

class Invitados extends Model
{
    protected $table = 'Invitados';
    protected $primaryKey = 'Id_Invitados';
    public $timestamps = true;

    protected $fillable = [
        'FK_Id_Persona',
        'FK_TipoInvitado',
        'Edificio',
        'CantVis',
        'MotivoVisit',
        'Fecha_Hora_Solicitada'
    ];

    public function persona()
    {
        return $this->belongsTo(Personas::class, 'FK_Id_Persona', 'Id_Persona');
    }

    public function TipoInvitado()
    {
        return $this->belongsTo(TipoInvitado::class, 'FK_TipoInvitado', 'Id_TipoInvitado');
    }
    
    public function solicitud()
    {
        return $this->hasOne(SolicitudInvitado::class, 'FK_Id_Invitados', 'Id_Invitados');
    }
    
}
