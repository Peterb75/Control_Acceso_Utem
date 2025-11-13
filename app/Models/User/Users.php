<?php
namespace App\Models\User;

use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Persona\Personas;
use App\Models\User\TipoUsers;
use App\Models\User\Puestos;
use App\Models\User\Areas;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Users extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $table = 'Users';
    protected $primaryKey = 'Id_Users';

    protected $fillable = [
        'FK_Id_Persona',
        'FK_TipoUsuario',
        'FK_Puesto',
        'FK_Area',
        'Num_Iden',
        'Password',
        'Carrera',
        'Grupo',
        'Activo',
        'HoraFija_Entrada',
        'HoraFija_Salida',
    ];

    protected $hidden = [
        'Password',
    ];

    public function Personas()
    {
        return $this->belongsTo(Personas::class, 'FK_Id_Persona', 'Id_Persona');
    }

    public function TipoUsers()
    {
        return $this->belongsTo(TipoUsers::class, 'FK_TipoUsuario', 'Id_TipoUsuario');
    }

    public function Puesto()
    {
        return $this->belongsTo(Puestos::class, 'FK_Puesto', 'Id_Puesto');
    }

    public function Area()
    {
        return $this->belongsTo(Areas::class, 'FK_Area', 'Id_Area');
    }
}
