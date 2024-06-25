<?php

namespace App\Models\Invitado;

use Illuminate\Database\Eloquent\Model;

class SolicitudInvitado extends Model
{
    protected $table = 'Solictud_Vis';
    protected $primaryKey = 'Id_solicitud';
    public $timestamps = false;

    protected $fillable = [
        'FK_Id_Invitados'
    ];

    public function Invitados()
    {
        return $this->belongsTo('App\Models\Invitado\Invitados', 'FK_Id_Invitados', 'Id_Invitados');
    }

}
