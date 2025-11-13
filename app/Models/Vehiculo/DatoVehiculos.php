<?php

namespace App\Models\Vehiculo;

use Illuminate\Database\Eloquent\Model;

class DatoVehiculos extends Model
{
    protected $table = 'DatoV';
    protected $primaryKey = 'Id_DatoV';
    public $timestamps = true;

    protected $fillable = [
        'MarcaV',
        'ModeloV',
        'ColorV',
        'Placas',
    ];

    public function vehiculos()
    {
        return $this->hasMany(Vehiculos::class, 'FK_Id_DatoV');
    }
}
