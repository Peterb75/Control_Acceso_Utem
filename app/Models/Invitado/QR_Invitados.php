<?php

namespace App\Models\Invitado;

use Illuminate\Database\Eloquent\Model;

class QR_Invitados extends Model
{
    protected $table = 'QR_Invitados';
    protected $primaryKey = 'Id_QRInv';
    public $timestamps = true;

    protected $fillable = [
        'FK_Id_Aceptado',
        'Activo',
        'QR_invit',
    ];

    public function persona()
    {
        return $this->belongsTo('App\Models\Invitado\VisitAceptados', 'FK_Id_Aceptado', 'Id_Aceptado');
    }

}
