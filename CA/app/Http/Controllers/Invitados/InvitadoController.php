<?php

namespace App\Http\Controllers\Invitados;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Persona\Personas;
use App\Models\Invitado\Invitados;
use App\Models\Invitado\TipoInvitado;
use App\Models\Invitado\SolicitudInvitado;
use App\Models\Vehiculo\Vehiculos;
use App\Models\Vehiculo\DatoVehiculos;

use Illuminate\Support\Facades\DB;

class InvitadoController extends Controller
{

    

    public function showForm(Request $request)
    {
        $tipoInvitado = $request->get('tipoInvitado');
        switch ($tipoInvitado) {
            case 1:
                $tiposInvitados = TipoInvitado::where('Id_TipoInvitado', 1)->get(); 
                break;
            case 2:
                $tiposInvitados = TipoInvitado::where('Id_TipoInvitado', 2)->get();
                break;
            case 3:
                $tiposInvitados = TipoInvitado::where('Id_TipoInvitado', 3)->get();
                break;
            default:
                return redirect()->back()->with('error', 'Tipo de invitado no válido');
        }
            return view('form', compact('tiposInvitados'));
    }
        
    public function CreateInvPeatonal(Request $request)
    {
        DB::beginTransaction();

        try {
            // Validar datos de entrada
            $validatedData = $request->validate([
                'Nombres' => 'required|string|max:50',
                'ApellidoP' => 'required|string|max:50',
                'ApellidoM' => 'required|string|max:50',
                'Correo' => 'required|string|email|max:150',
                'TipoTransporte' => 'required|string|max:60',
                'FK_TipoInvitado' => 'required|integer|exists:TipoInvitado,Id_TipoInvitado',
                'Edificio' => 'required|string|max:30',
                'CantVis' => 'required|integer',
                'MotivioVisit' => 'required|string|max:100',
                'FechaSolicitada' => 'required|date'
            ]);

            // Crear persona
            $persona = Personas::create([
                'Nombres' => $validatedData['Nombres'],
                'ApellidoP' => $validatedData['ApellidoP'],
                'ApellidoM' => $validatedData['ApellidoM'],
                'Correo' => $validatedData['Correo'],
                'TipoTransporte' => $validatedData['TipoTransporte'],
            ]);

            // Crear invitado
            $Invitado = Invitados::create([
                'FK_Id_Persona' => $persona->Id_Persona,
                'FK_TipoInvitado' => $validatedData['FK_TipoInvitado'],
                'Edificio' => $validatedData['Edificio'],
                'CantVis' => $validatedData['CantVis'],
                'MotivioVisit' => $validatedData['MotivioVisit'],
                'FechaSolicitada' => $validatedData['FechaSolicitada']
            ]);

            //Solicitud Invitado
            SolicitudInv::create([
                'FK_Id_Invitados' => $Invitado->Id_Invitados
            ]);

            DB::commit();

            return redirect()->back()->with('success', 'Persona, invitado y vehículo creados con éxito');

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Error al crear persona e invitado', 'error' => $e->getMessage()], 500);
        }
    }

    public function CreateInvVehiculo(Request $request)
    {
        DB::beginTransaction();

        try {
            // Validar datos de entrada
            $validatedData = $request->validate([
                'Nombres' => 'required|string|max:50',
                'ApellidoP' => 'required|string|max:50',
                'ApellidoM' => 'required|string|max:50',
                'Correo' => 'required|string|email|max:150',
                'TipoTransporte' => 'required|string|max:60',
                'FK_TipoInvitado' => 'required|integer|exists:TipoInvitado,Id_TipoInvitado',
                'Edificio' => 'required|string|max:30',
                'CantVis' => 'required|integer',
                'MotivioVisit' => 'required|string|max:100',
                'FechaSolicitada' => 'required|date',
                'MarcaV' => 'required|string|max:100', 
                'ModeloV' => 'required|string|max:100',
                'ColorV' => 'required|string|max:40|',
                'Placas' => 'nullable|string|max:80',
            ]);

            // Crear persona
            $persona = Personas::create([
                'Nombres' => $validatedData['Nombres'],
                'ApellidoP' => $validatedData['ApellidoP'],
                'ApellidoM' => $validatedData['ApellidoM'],
                'Correo' => $validatedData['Correo'],
                'TipoTransporte' => $validatedData['TipoTransporte'],
            ]);

            // Crear invitado
            $Invitado = Invitados::create([
                'FK_Id_Persona' => $persona->Id_Persona,
                'FK_TipoInvitado' => $validatedData['FK_TipoInvitado'],
                'Edificio' => $validatedData['Edificio'],
                'CantVis' => $validatedData['CantVis'],
                'MotivioVisit' => $validatedData['MotivioVisit'],
                'FechaSolicitada' => $validatedData['FechaSolicitada']
            ]);

            //Crear Dato Vehicular
            $DatoV = DatoVehiculos::create([
                'MarcaV' => $validatedData['MarcaV'],
                'ModeloV' => $validatedData['ModeloV'],
                'ColorV'=> $validatedData['ColorV'],
                'Placas' => $validatedData['Placas'],        
            ]);

            //Crear Vehiculo
            Vehiculos::create([
                'FK_Id_Persona' => $persona->Id_Persona,
                'FK_Id_DatoV' => $DatoV->Id_DatoV,        
            ]);          

            SolicitudInvitado::create([
                'FK_Id_Invitados' => $Invitado->Id_Invitados
            ]);

            DB::commit();
            
            return redirect()->back()->with('success', 'Persona, invitado y vehículo creados con éxito');
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Error al crear persona e invitado', 'error' => $e->getMessage()], 500);
        }
    }

}