<?php

namespace App\Models\Invitado;

use Illuminate\Database\Eloquent\Model;

class Invitados extends Model
{
    protected $table = 'Invitados';
    protected $primaryKey = 'Id_Invitados';
    public $timestamps = false;

    protected $fillable = [
        'FK_Id_Persona',
        'FK_TipoInvitado',
        'Edificio',
        'CantVis',
        'MotivioVisit',
        'FechaSolicitada'
    ];

    public function persona()
    {
        return $this->belongsTo('App\Models\Persona\Personas', 'FK_Id_Persona', 'Id_Persona');
    }

    public function TipoInvitado()
    {
        return $this->belongsTo('App\Models\Invitado\TipoInvitado', 'FK_TipoInvitado', 'Id_TipoInvitado');
    }
    
}
