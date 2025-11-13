<?php

namespace App\Models\Invitado;

use Illuminate\Database\Eloquent\Model;

class QR_Invitados extends Model
{
    protected $table = 'QR_Invitados';
    protected $primaryKey = 'Id_QRInv';
    public $timestamps = true;

    protected $fillable = [
        'FK_Id_Solicitud',
        'Activo',
        'QR_invit',
    ];

    public function PersonaInv()
    {
        return $this->belongsTo('App\Models\Invitado\SolicitudInvitado', 'FK_Id_Solicitud', 'Id_Aceptado');
    }


}
