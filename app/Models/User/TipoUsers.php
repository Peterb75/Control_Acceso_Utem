<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class TipoUsers extends Model
{
    protected $table = 'TipoUsuario';
    protected $primaryKey = 'Id_TipoUsuario';
    public $timestamps = false;

    protected $fillable = [
        'TipoUsuarios',
        'Descripcion',
        'FechaCreated',
    ];
}
