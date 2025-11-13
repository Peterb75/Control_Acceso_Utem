<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;

//Persona
use App\Models\Persona\Personas;

//USER
use App\Models\User\Users;
use App\Models\User\QR_Users;
use App\Models\ViewsDB\VW_User_Activos;
use App\Models\ViewsDB\VW_User_Inactivos;
use App\Models\ViewsDB\VW_User_Todos;


//Tipos de Usuarios, Areas, Puestos
use App\Models\User\Puestos;
use App\Models\User\Areas;
use App\Models\User\TipoUsers;


//Invitados
use App\Models\Invitado\Invitados;
use App\Models\Invitado\TipoInvitado;
use App\Models\Invitado\SolicitudInvitado;
use App\Models\Invitado\VisitAceptados;
use App\Models\Invitado\QR_Invitados;
use App\Models\ViewsDB\VW_SolInvitados_Pendientes;
use App\Models\ViewsDB\VW_SolInvitados_Aceptados;
use App\Models\ViewsDB\vw_solicitudes_general;
use App\Models\ViewsDB\VW_Solicitudes_Denegadas;

//Datos de Vehiculo
use App\Models\Vehiculo\Vehiculos;
use App\Models\Vehiculo\DatoVehiculos;

//Imagen QR
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

//Ayudas para ejecuciones
use App\Mail\PersonaMail;
use App\Mail\SolicitudDenegadaMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    //Users
    public function activos() {
        $usuarios = VW_User_Activos::all();
        return view('admin.users-activos', compact('usuarios'));
    }

    public function inactivos() {
        $usuarios = VW_User_Inactivos::all();
        return view('admin.users-inactivos', compact('usuarios'));
    }

    public function todos() {
        $usuarios = VW_User_Todos::all();
        return view('admin.users-todos', compact('usuarios'));
    }
    
    public function Users($Num_Iden)
    {
        $user = Users::where('Num_Iden', $Num_Iden)->first();

        if (!$user) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }

        return response()->json($user, 200);
    }

    //Funcion GET encontrar el tipo de usuario esto es por si utilizan un boton antes de entrar al formulario
    public function TipoUser(Request $request)
    {
        // Obtener el ID del tipo de invitado desde la solicitud GET    
        $id = $request->input('id');

        // Buscar el tipo de invitado en la base de datos
        $TipoUsers = TipoUsers::find($id);

        if (!$TipoUsers) {
            return response()->json(['error' => 'Tipo de invitado no encontrado'], 404);
        }

        // Devolver el tipo de invitado encontrado
        return response()->json($TipoUsers, 200);
    }

    public function ShowFormUser(){
            $tiposUsuarios = TipoUsers::all();
            $areas = Areas::all();
            $puestos = Puestos::all();

    return view('admin.Formcreateuser', compact('tiposUsuarios', 'areas', 'puestos'));
    }

    //Post Para crear Usuarios Dependiendo del tipo usuario
    //Tambien si se utiliza un tipo de vehiculo se agregara en el formulario
    public function CreateUser(Request $request)
    {
        DB::beginTransaction();

        try {
            // Validar datos de entrada
            $validatedData = $request->validate([
                'Nombres' => 'required|string|max:50',
                'ApellidoP' => 'required|string|max:50',
                'ApellidoM' => 'required|string|max:50',
                'Correo' => 'required|string|email|max:150',
                'TipoTransporte' => 'required|string|in:Peatonal,Vehicular',
                'TipoVehiculo' => 'nullable|string|max:100',
                'FK_TipoUsuario' => 'required|integer|exists:TipoUsuarios,Id_TipoUsuario',
                'FK_Id_Puesto' => 'nullable|integer', //|exists:Puestos,Id_Puesto
                'FK_Id_Area' => 'nullable|integer', //|exists:Areas,Id_Area
                'Num_Iden' => 'required|integer',
                'Password' => 'required|string|max:255',
                'Carrera' => 'nullable|string|max:30',
                'Grupo' => 'nullable|string|max:30',
                'Activo' => 'required|integer|in:0,1',
                'HoraFija_Entrada' => 'required|date_format:H:i:s',
                'HoraFija_Salida' => 'required|date_format:H:i:s',
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

            // Crear Usuario
            $User = Users::create([
                'FK_Id_Persona' => $persona->Id_Persona,
                'FK_TipoUsuario' => $validatedData['FK_TipoUsuario'],
                'FK_Id_Puesto' => $validatedData['FK_Id_Puesto'],
                'FK_Id_Area' => $validatedData['FK_Id_Area'],
                'Num_Iden' => $validatedData['Num_Iden'],
                'Password' =>  Hash::make($validatedData['Password']),
                'Carrera' => $validatedData['Carrera'],
                'Grupo' => $validatedData['Grupo'],
                'Activo' => $validatedData['Activo'],
                'HoraFija_Entrada' => $validatedData['HoraFija_Entrada'],
                'HoraFija_Salida' => $validatedData['HoraFija_Salida'],
            ]);

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

                        // Generar un código de identificación único
                        $codigoIdentificacion = uniqid();
    
                        $qrCode = QrCode::create($codigoIdentificacion);
                        $writer = new PngWriter();
                        $qrPath = public_path('qrcodes/' . $codigoIdentificacion . '.png');
                        $writer->write($qrCode)->saveToFile($qrPath);
            
                        // Creación de QR para el invitado
                        $QRInvitados = QR_Users::create([
                            'FK_Id_User' => $User->Id_Users,
                            'QR_imgUser' => $codigoIdentificacion,
                        ]);
                       
                        //Conseguir el correo
                        $correo = $persona->Correo;
                        // Enviar el correo a la persona
                        Mail::to($correo)->send(new PersonaMail($qrPath, $persona));
                        DB::commit();

                        return response()->json(['message' => 'Usuario creado con éxito'], 200);

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error al crear usuario: ' . $e->getMessage());
            return response()->json(['message' => 'Error al crear persona e Usuario', 'error' => $e->getMessage()], 500);
        }
    }

    //Actualizar el Usuario UN PUT
    public function UpdateUser(Request $request, $id)
    {
        DB::beginTransaction();
    
        try {
            // Validar datos de entrada
            $validatedData = $request->validate([
                'Nombres' => 'required|string|max:50',
                'ApellidoP' => 'required|string|max:50',
                'ApellidoM' => 'required|string|max:50',
                'Correo' => 'required|string|email|max:150',
                'TipoTransporte' => 'required|string|in:Peatonal,Vehiculo',
                'TipoVehiculo' => 'nullable|string|max:100',
                'FK_TipoUsuario' => 'required|integer|exists:TipoUsuario,Id_TipoUsuario',
                'FK_Id_Puesto' => 'nullable|integer|exists:puesto,Id_Puesto',
                'FK_Id_Area' => 'nullable|integer|exists:area,Id_Area',
                'Num_Iden' => 'required|string|max:30',
                'Password' => 'required|string|max:20',
                'Carrera' => 'required|string|max:30',
                'Grupo' => 'required|string|max:30',
                'Activo' => 'required|integer',
                'HoraFija_Entrada' => 'required|date_format:H:i:s',
                'HoraFija_Salida' => 'required|date_format:H:i:s',
            ]);
    
            // Actualizar persona
            $persona = Personas::findOrFail($id);
            $persona->update([
                'Nombres' => $validatedData['Nombres'],
                'ApellidoP' => $validatedData['ApellidoP'],
                'ApellidoM' => $validatedData['ApellidoM'],
                'Correo' => $validatedData['Correo'],
                'TipoTransporte' => $validatedData['TipoTransporte'],
                'TipoVehiculo' => $validatedData['TipoVehiculo'],
            ]);
    
            // Actualizar Usuario
            $user = Users::where('FK_Id_Persona', $persona->Id_Persona)->firstOrFail();
            $user->update([
                'FK_TipoUsuario' => $validatedData['FK_TipoUsuario'],
                'FK_Id_Puesto' => $validatedData['FK_Id_Area'],
                'FK_Id_Area' => $validatedData['FK_Id_Area'],
                'Num_Iden' => $validatedData['Num_Iden'],
                'Carrera' => $validatedData['Carrera'],
                'Grupo' => $validatedData['Grupo'],
                'Activo' => $validatedData['Activo'],
                'HoraFija_Entrada' => $validatedData['HoraFija_Entrada'],
                'HoraFija_Salida' => $validatedData['HoraFija_Salida'],
            ]);

            // Si se proporciona una nueva contraseña, hashearla
            if (!empty($validatedData['Password'])) {
                $userData['Password'] = Hash::make($validatedData['Password']);
            }

            // Actualizar el usuario
            $user->update($userData);
    
            // Verificar y actualizar datos específicos del vehículo si es necesario
            if ($validatedData['TipoTransporte'] === 'Vehiculo') {
                $validatedVehicleData = $request->validate([
                    'MarcaV' => 'required|string|max:100', 
                    'ModeloV' => 'required|string|max:100',
                    'ColorV' => 'required|string|max:40',
                    'Placas' => 'nullable|string|max:80',
                ]);
    
                // Actualizar datos vehiculares
                $vehiculo = Vehiculos::where('FK_Id_Persona', $persona->Id_Persona)->first();
                if ($vehiculo) {
                    $datoV = DatoVehiculos::findOrFail($vehiculo->FK_Id_DatoV);
                    $datoV->update([
                        'MarcaV' => $validatedVehicleData['MarcaV'],
                        'ModeloV' => $validatedVehicleData['ModeloV'],
                        'ColorV' => $validatedVehicleData['ColorV'],
                        'Placas' => $validatedVehicleData['Placas'],        
                    ]);
                } else {
                    $datoV = DatoVehiculos::create([
                        'MarcaV' => $validatedVehicleData['MarcaV'],
                        'ModeloV' => $validatedVehicleData['ModeloV'],
                        'ColorV' => $validatedVehicleData['ColorV'],
                        'Placas' => $validatedVehicleData['Placas'],        
                    ]);
                    Vehiculos::create([
                        'FK_Id_Persona' => $persona->Id_Persona,
                        'FK_Id_DatoV' => $datoV->Id_DatoV,        
                    ]);
                }
            }
    
            DB::commit();
    
            return redirect()->back()->with('success', 'Persona y usuario actualizados con éxito');
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Error al actualizar persona y usuario', 'error' => $e->getMessage()], 500);
        }
    }

    //PUT
    public function BajaUser(Request $request, $id)
    {
        DB::beginTransaction();
    
        try {    

            // Actualiza para dar de baja al user
            $persona = Users::findOrFail($id);
            if ($persona->Activo == 1) {
                $persona->update(['Activo' => 0]);
            }
    
            DB::commit();
    
            return redirect()->back()->with('success', 'Se a dado de Baja el alumno');
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Error al actualizar estado de activo', 'error' => $e->getMessage()], 500);
        }
    }
    
    //PUT
    public function AltaUser(Request $request, $id)
    {
        DB::beginTransaction();
    
        try {    
            // Actualiza para dar de alta al User
            $persona = Users::findOrFail($id);
            if ($persona->Activo == 0) {
                $persona->update(['Activo' => 1]);
            }
    
            DB::commit();
    
            return redirect()->back()->with('success', 'Se a dado de Alta el alumno');
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Error al actualizar estado de activo', 'error' => $e->getMessage()], 500);
        }
    }    

    //Invitados

    //Muestra a todas las Solicitudes
    public function ShowSolicitudes()
    {
        // Obtener todas las solicitudes de invitados con los datos de invitados relacionados
        $solicitudes = VW_SolInvitados_Pendientes::all();
        return view('admin.index', compact('solicitudes'));
    }

    public function ShowSolicitudesAceptados()
    {
        $SolicitudesAceptadas = VW_SolInvitados_Aceptados::all();
        return view('admin.aceptados', compact('SolicitudesAceptadas'));
    }

    public function Muestratodas()
    {
        $solicitudesgeneral = vw_solicitudes_general::all();
        return view('admin.todassolid', compact('solicitudesgeneral'));
    }

    public function ShowSolicDenegadas(){
        $solicitudesRechazadas = vw_Solicitudes_Denegadas::all();
        return view('admin.solicitudesdenegadas', compact('solicitudesRechazadas'));
    }


    //Busca a los Invitados por el Nombre
    public function showInvitadosName($Nombre)
    {
        // Buscar la persona por su nombre
        $persona = VW_SolInvitados_Pendientes::where('Nombres', $Nombre)->first();

        if (!$persona) {
            return response()->json(['error' => 'Persona no encontrada'], 404);
        }
        return response()->json($persona, 200);
    }

    //Actualiza los datos del Invitado
    public function UpdateInvitado()
    {
        DB::beginTransaction();

        try {
            // Validar datos comunes
            $validatedData = $request->validate([
                'Nombres' => 'required|string|max:50',
                'ApellidoP' => 'required|string|max:50',
                'ApellidoM' => 'required|string|max:50',
                'Correo' => 'required|string|email|max:150',
                'TipoTransporte' => 'required|string|in:Peatonal,Vehiculo',
                'TipoVehiculo' => 'nullable|string|max:100',
                'FK_TipoInvitado' => 'required|integer|exists:TipoInvitado,Id_TipoInvitado',
                'Edificio' => 'required|string|max:30',
                'CantVis' => 'required|integer',
                'MotivioVisit' => 'required|string|max:100',
                'FechaSolicitada' => 'required|date',
            ]);
    
            // Actualizar persona
            $persona = Personas::findOrFail($id);
            $persona->update([
                'Nombres' => $validatedData['Nombres'],
                'ApellidoP' => $validatedData['ApellidoP'],
                'ApellidoM' => $validatedData['ApellidoM'],
                'Correo' => $validatedData['Correo'],
                'TipoTransporte' => $validatedData['TipoTransporte'],
                'TipoVehiculo' => $validatedData['TipoVehiculo'],
            ]);
    
            // Actualizar invitado
            $invitado = Invitados::where('FK_Id_Persona', $persona->Id_Persona)->firstOrFail();
            $invitado->update([
                'FK_TipoInvitado' => $validatedData['FK_TipoInvitado'],
                'Edificio' => $validatedData['Edificio'],
                'CantVis' => $validatedData['CantVis'],
                'MotivioVisit' => $validatedData['MotivioVisit'],
                'FechaSolicitada' => $validatedData['FechaSolicitada'],
            ]);
    
            // Verificar y actualizar datos específicos del vehículo si es necesario
            if ($validatedData['TipoTransporte'] === 'Vehicular') {
                $validatedVehicleData = $request->validate([
                    'MarcaV' => 'required|string|max:100', 
                    'ModeloV' => 'required|string|max:100',
                    'ColorV' => 'required|string|max:40',
                    'Placas' => 'nullable|string|max:80',
                ]);
    
                // Actualizar datos vehiculares
                $vehiculo = Vehiculos::where('FK_Id_Persona', $persona->Id_Persona)->first();
                if ($vehiculo) {
                    $datoV = DatoVehiculos::findOrFail($vehiculo->FK_Id_DatoV);
                    $datoV->update([
                        'MarcaV' => $validatedVehicleData['MarcaV'],
                        'ModeloV' => $validatedVehicleData['ModeloV'],
                        'ColorV' => $validatedVehicleData['ColorV'],
                        'Placas' => $validatedVehicleData['Placas'],        
                    ]);
                } else {
                    $datoV = DatoVehiculos::create([
                        'MarcaV' => $validatedVehicleData['MarcaV'],
                        'ModeloV' => $validatedVehicleData['ModeloV'],
                        'ColorV' => $validatedVehicleData['ColorV'],
                        'Placas' => $validatedVehicleData['Placas'],        
                    ]);
                    Vehiculos::create([
                        'FK_Id_Persona' => $persona->Id_Persona,
                        'FK_Id_DatoV' => $datoV->Id_DatoV,        
                    ]);
                }
            }
    
            DB::commit();
    
            return redirect()->back()->with('success', 'Persona e invitado actualizados con éxito');
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Error al actualizar persona e invitado', 'error' => $e->getMessage()], 500);
        }
    }

    //Acepta la solicitud y crea un QR que tendra el invitado para tener acceso a entrar a la Universidad
    public function AceptarInv(Request $request)
    {   
        try {
            // Validar datos de entrada
            $validatedData = $request->validate([
                'FK_Id_Solicitud' => 'required',
                'Fecha_Hora_Solicitada' => 'required|date_format:Y-m-d\TH:i',
            ]);
    
            // Encontrar la solicitud y actualizar su estado
            $solicitud = SolicitudInvitado::findOrFail($validatedData['FK_Id_Solicitud']);
            $solicitud->update([
                'Estado' => 'Aceptado',
                'FK_Id_UserAccion' => Auth::id()
            ]);
    
            // Actualizar la fecha y hora solicitada en la solicitud
            $solicitud->update([
                'Fecha_Hora_Solicitada' => $validatedData['Fecha_Hora_Solicitada']
            ]);
    
            // Generar un código de identificación único para el QR
            $codigoIdentificacion = uniqid();
    
            // Crear el código QR y guardarlo en un archivo PNG
            $qrCode = QrCode::create($codigoIdentificacion);
            $writer = new PngWriter();
            $qrPath = public_path('qrcodes/' . $codigoIdentificacion . '.png');
            $writer->write($qrCode)->saveToFile($qrPath);
    
            // Crear registro del código QR para el invitado
            $QRInvitados = QR_Invitados::create([
                'FK_Id_Solicitud' => $solicitud->Id_Solicitud,
                'QR_invit' => $codigoIdentificacion,
            ]);
                        
            // Obtener la información de la persona asociada a la solicitud
            $persona = $solicitud->invitados->persona;
            $correo = $persona->Correo;
    
            // Enviar el correo electrónico con el código QR adjunto
            Mail::to($correo)->send(new PersonaMail($qrPath, $persona));
    
            // Redirigir de vuelta con un mensaje de éxito
            return redirect()->back()->with('success', 'Se ha enviado el correo con éxito');
        } catch (\Exception $e) {
            // Manejar errores
            return response()->json([
                'message' => 'Ocurrió un error al aceptar la solicitud.',
                'error' => $e->getMessage(),
            ]);
        }
    }
    
    public function DenegarInv(Request $request,$solicitudId){
        $validatedData = $request->validate([
            'Motivo_Rechazo' => 'required|string|max:250',
        ]);

        // Buscar la solicitud
        $solicitud = SolicitudInvitado::findOrFail($solicitudId);

        // Actualizar los campos
        $solicitud->update([
            'Estado' => 'Denegado',
            'Motivo_Rechazo' => $validatedData['Motivo_Rechazo'],
            'FK_Id_UserAccion' => Auth::id(),
        ]);

            // Generar un código de identificación único para el QR
            $codigoIdentificacion = uniqid();
    
            // Crear el código QR y guardarlo en un archivo PNG
            $qrCode = QrCode::create($codigoIdentificacion);
            $writer = new PngWriter();
            $qrPath = public_path('qrcodes/' . $codigoIdentificacion . '.png');
            $writer->write($qrCode)->saveToFile($qrPath);
    
            // Crear registro del código QR para el invitado
            $QRInvitados = QR_Invitados::create([
                'FK_Id_Solicitud' => $solicitud->Id_Solicitud,
                'QR_invit' => $codigoIdentificacion,
            ]);
                        
            // Obtener la persona e email del invitado
            $persona = $solicitud->invitados->persona;
            $correo = $persona->Correo;

            // Enviar correo de rechazo
            Mail::to($correo)->send(new SolicitudDenegadaMail($persona, $solicitud)); 
        
        // Redirigir con mensaje
        return redirect()->back()->with('success', 'La solicitud fue denegada correctamente.');    }
}