<?php

namespace App\Http\Controllers\RegistrosGeneral;

use App\Models\Persona\RegistroEntrada;
use App\Models\Persona\RegistroSalida;
use App\Models\User\QR_Users;
use App\Models\Invitado\QR_Invitados;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RegistrosController extends Controller
{

    public function REntrada(Request $request)
    {
        $ValidateData = $request->validate([
            'FK_Id_Persona' => 'required|integer',
            'Entrada' => 'required'
        ]);

        $QR =  QR_Users::get();

        if($QR === 'ad')
        {

        }else{
            return response()->json(['Mesagge' => 'El codigo QR no es correcto']);
        }

        RegistroEntrada::create([
            'FK_Id_Persona' => $ValidateData['FK_Id_Persona'],
            'Entradax' => now()
        ]);

        return response()->json(['Message' => 'Se a registrado correctamente']);
    }
    
    public function RSalida()
    {
        $ValidateData = $request->validate([
            'FK_Id_Persona' => 'required|integer',
            'Salida' => 'required'
        ]);

        RegistroSalida::create([
            'FK_Id_Persona' => $ValidateData[''],
            'Salida' => now()
        ]);

        return response()->json(['Message' => 'Se a registrado correctamente']);
    }

}
