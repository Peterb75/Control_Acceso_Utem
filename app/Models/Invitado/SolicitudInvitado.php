<?php

namespace App\Models\Invitado;

use Illuminate\Database\Eloquent\Model;

class SolicitudInvitado extends Model
{
    protected $table = 'solicitud_vis';
    protected $primaryKey = 'Id_Solicitud';
    public $timestamps = true;

    protected $fillable = [
        'FK_Id_Invitados',
        'Estado',
        'Motivo_Rechazo',
        'FK_Id_UserAccion',
    ];

    public function invitados()
    {
        return $this->belongsTo(Invitados::class, 'FK_Id_Invitados', 'Id_Invitados');
    }

    public function User()
    {
        return $this->belongsTo('App\Models\User\Users', 'FK_Id_UserAceptado', 'Id_Users');
    }

}
