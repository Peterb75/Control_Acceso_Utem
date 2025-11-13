<?php

namespace App\Http\Controllers\Invitados;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Persona\Personas;
use App\Models\Invitado\TipoInvitado;
use App\Models\Invitado\Invitados;
use App\Models\Invitado\companionsinv;
use App\Models\Vehiculo\Vehiculos;
use App\Models\Vehiculo\DatoVehiculos;
use App\Models\Invitado\SolicitudInvitado;

use Illuminate\Support\Facades\DB;

class InvitadoController extends Controller
{
    public function createInvitado(Request $request)
    {
        DB::beginTransaction();
    
        try {
            
            // Validar datos comunes
            $validatedData = $request->validate([
                'Nombres' => 'required|string|max:50',
                'ApellidoP' => 'required|string|max:50',
                'ApellidoM' => 'required|string|max:50',
                'Correo' => 'required|string|email|max:150',
                'TipoTransporte' => 'required|string|in:Peatonal,Vehicular',
                'TipoVehiculo' => 'nullable|string|max:100',
                'FK_TipoInvitado' => 'required|integer|exists:TipoInvitado,Id_TipoInvitado',
                'Edificio' => 'required|string|max:30',
                'CantVis' => 'required|integer',
                'NombreCompleto' => 'nullable|string|max:50',
                'MotivoVisit' => 'required|string|max:100',
                'Fecha_Hora_Solicitada' => 'required|date_format:Y-m-d\TH:i',
            ]);

            // Crear persona
            $persona = Personas::create([
                'Nombres' => $validatedData['Nombres'],
                'ApellidoP' => $validatedData['ApellidoP'],
                'ApellidoM' => $validatedData['ApellidoM'],
                'Correo' => $validatedData['Correo'],
                'TipoTransporte' => $validatedData['TipoTransporte'],
                'TipoVehiculo' => $validatedData['TipoVehiculo'],
            ]);
    
            // Crear invitado
            $invitado = Invitados::create([
                'FK_Id_Persona' => $persona->Id_Persona,
                'FK_TipoInvitado' => $validatedData['FK_TipoInvitado'],
                'Edificio' => $validatedData['Edificio'],
                'CantVis' => $validatedData['CantVis'],
                'MotivoVisit' => $validatedData['MotivoVisit'],
                'Fecha_Hora_Solicitada' => $validatedData['Fecha_Hora_Solicitada'],
            ]);
    
            // Verificar y crear datos específicos del vehículo si es necesario
            if ($validatedData['TipoTransporte'] === 'Vehicular') {
                $validatedVehicleData = $request->validate([
                    'MarcaV' => 'required|string|max:100',
                    'ModeloV' => 'required|string|max:100',
                    'ColorV' => 'required|string|max:40',
                    'Placas' => 'nullable|string|max:80',
                ]);
    
                // Crear datos vehiculares
                $datoV = DatoVehiculos::create([
                    'MarcaV' => $validatedVehicleData['MarcaV'],
                    'ModeloV' => $validatedVehicleData['ModeloV'],
                    'ColorV' => $validatedVehicleData['ColorV'],
                    'Placas' => $validatedVehicleData['Placas'],
                ]);
    
                // Asociar vehículo a persona
                Vehiculos::create([
                    'FK_Id_Persona' => $persona->Id_Persona,
                    'FK_Id_DatoV' => $datoV->Id_DatoV,
                ]);
            }

            for ($i = 1; $i < $request->input('CantVis'); $i++) {
                if ($request->has('NombreCompleto' . $i)) {
                    companionsinv::create([
                        'FK_idcompanions' => $invitado->Id_Invitados,
                        'NombreCompleto' => $request->input('NombreCompleto' . $i)
                    ]);
                }
            }
    
            // Crear solicitud de invitado
            SolicitudInvitado::create([
                'FK_Id_Invitados' => $invitado->Id_Invitados,
            ]);
    
            DB::commit();
    
            return redirect()->back()->with('success', 'Persona e invitado creados con éxito');

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Error al crear persona e invitado', 'error' => $e->getMessage()], 500);
        }
    }
    
}