<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class QR_Users extends Model
{
    protected $table = 'QR_Usuarios';
    protected $primaryKey = 'Id_QRUser';
    public $timestamps = true;

    protected $fillable = [
        'FK_Id_User',
        'Activoqr',
        'QR_imgUser'
    ];

    public function persona()
    {
        return $this->belongsTo('App\Models\User\Users', 'FK_Id_User', 'Id_Users');
    }

}
