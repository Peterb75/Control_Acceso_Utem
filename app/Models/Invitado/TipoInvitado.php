<?php

namespace App\Models\Invitado;

use Illuminate\Database\Eloquent\Model;

class TipoInvitado extends Model
{
    protected $table = 'TipoInvitado';
    protected $primaryKey = 'Id_TipoInvitado';
    public $timestamps = true;

    protected $fillable = [
        'Id_TipoInvitado',
        'Tipo_Invitado',
        'Descripcion',
        'FechaCreated',
    ];
}
