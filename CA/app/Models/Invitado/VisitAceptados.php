<?php

namespace App\Models\Invitado;

use Illuminate\Database\Eloquent\Model;

class VisitAceptados extends Model
{
    protected $table = 'VisitAceptados';
    protected $primaryKey = 'Id_Aceptado';
    public $timestamps = false;

    protected $fillable = [
        'FK_Id_solicitud',
        'FK_Id_UserAceptado',
    ];

    public function Solicitud()
    {
        return $this->belongsTo('App\Models\Invitado\SolicitudInvitado', 'FK_Id_solicitud', 'Id_solicitud');
    }

    public function User()
    {
        return $this->belongsTo('App\Models\User\Users', 'FK_Id_UserAceptado', 'Id_Users');
    }


}
