<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Entrada;
use App\Models\Salida;
use App\Models\Persona\Personas;
use App\Models\Persona\RegistroEntrada;
use App\Models\Persona\RegistroSalida;

use App\Models\Invitado\QR_Invitados;
use App\Models\User\QR_Users;



use App\Models\Invitado\VisitAceptados;
use App\Models\Invitado\SolicitudInvitado;
use App\Models\Invitado\Invitados;

class QRController extends Controller
{
    public function verifyQR(Request $request)
    {
        

        try {
            $qrCode = $request->input('qr');
            if (!$qrCode) {
                return response()->json(['error' => 'Código QR no proporcionado.'], 400);
            }

            $qrInvitado = QR_Invitados::where('QR_invit', $qrCode)->first();
            

            if (!$qrInvitado) {
                return response()->json(['error' => 'Código QR no encontrado.'], 404);
            }

            if ($qrInvitado->Activo == 0) {
                return response()->json(['error' => 'Código QR vencido.'], 400);
            }

            

            $solicitudInvitado = SolicitudInvitado::find($qrInvitado->FK_Id_Solicitud);
            if (!$solicitudInvitado) {
                return response()->json(['error' => 'Solicitud no encontrada.'], 404);
            }

            $invitado = Invitados::find($solicitudInvitado->FK_Id_Invitados);
            if (!$invitado) {
                return response()->json(['error' => 'Invitado no encontrado.'], 404);
            }

            $personaId = $invitado->FK_Id_Persona;

            // Verificar si ya tiene una entrada registrada
            $entrada = RegistroEntrada::where('FK_Id_Persona', $personaId)->first();
            if (!$entrada) {
                // Registrar entrada
                RegistroEntrada::create(['FK_Id_Persona' => $personaId]);
                return response()->json(['success' => true, 'action' => 'entrada', 'message' => 'Entrada registrada con éxito.']);
            }

            // Verificar si ya tiene una salida registrada
            $salida = RegistroSalida::where('FK_Id_Persona', $personaId)->first();
            if (!$salida) {
                // Registrar salida
                RegistroSalida::create(['FK_Id_Persona' => $personaId]);
                // Desactivar el QR
                $qrInvitado->Activo = 0;
                $qrInvitado->save();
                return response()->json(['success' => true, 'action' => 'salida', 'message' => 'Salida registrada con éxito.']);
            }

            return response()->json(['error' => 'Código QR ya fue utilizado.'], 400);
        } catch (\Exception $e) {
            
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function showMyQR()
    {
        $user = auth()->user();

        $qrUsuario = QR_Users::where('FK_Id_User', $user->Id_Users)->first();

        if (!$qrUsuario) {
            return redirect()->back()->with('error', 'No tienes un código QR asignado.');
        }

        return view('Usuarios.home', compact('user', 'qrUsuario'));
    }


}

