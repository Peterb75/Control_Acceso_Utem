<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;
use App\Models\User\Users;

class TipoUsers extends Model
{
    protected $table = 'TipoUsuarios';
    protected $primaryKey = 'Id_TipoUsuario';
    public $timestamps = true;

    protected $fillable = [
        'TipoUsuarios',
        'Descripcion'
    ];

}

