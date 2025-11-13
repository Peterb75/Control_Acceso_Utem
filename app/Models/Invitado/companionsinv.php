<?php

namespace App\Models\Invitado;

use Illuminate\Database\Eloquent\Model;
use App\Models\Invitado\Invitados;

class companionsinv extends Model
{
    protected $table = 'companionsinv';
    protected $primaryKey = 'Id_Invitados';
    public $timestamps = true;

    protected $fillable = [
        'FK_idcompanions',
        'NombreCompleto'
    ];

    public function Invitados()
    {
        return $this->belongsTo(Personas::class, 'FK_idcompanions', 'Id_Invitados');
    }
}
