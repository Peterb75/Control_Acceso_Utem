<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class Areas extends Model
{
    protected $table = 'Areas';
    protected $primaryKey = 'Id_Area';
    public $timestamps = true;

    protected $fillable = [
        'NombreArea',
        'Descripcion'
    ];

}
