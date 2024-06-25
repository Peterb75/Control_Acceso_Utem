<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function CreateEstudiante(Request $request)
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
                'FK_TipoUsuario' => 'required|integer|exists:FK_TipoUsuario,Id_TipoUsuario',
                'Num_Iden' => 'required|string|max:30',
                'Password' => 'required|string|max:30',
                'Carrera' => 'required|string|max:30',
                'Grupo' => 'required|string|max:30',
                'Activo' => 'required|string|max:30',
                'HoraFija_Entrada' => 'required|integer',
                'HoraFija_Salida' => 'required|string|max:100',
            ]);

            // Crear persona
            $persona = Personas::create([
                'Nombres' => $validatedData['Nombres'],
                'ApellidoP' => $validatedData['ApellidoP'],
                'ApellidoM' => $validatedData['ApellidoM'],
                'Correo' => $validatedData['Correo'],
                'TipoTransporte' => $validatedData['TipoTransporte'],
            ]);

            // Crear Usuario Alumno
            $User = Users::create([
                'FK_Id_Persona' => $persona->Id_Persona,
                'FK_TipoUsuario' => $validatedData['FK_TipoUsuario'],
                'Num_Iden' => $validatedData['Num_Iden'],
                'Password' => $validatedData['Password'],
                'Carrera' => $validatedData['Carrera'],
                'Grupo' => $validatedData['Grupo'],
                'Activo' => $validatedData['Activo'],
                'HoraFija_Entrada' => $validatedData['HoraFija_Entrada'],
                'HoraFija_Salida' => $validatedData['HoraFija_Salida'],
            ]);


            DB::commit();

            return redirect()->back()->with('success', 'Persona, invitado y vehículo creados con éxito');

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Error al crear persona e invitado', 'error' => $e->getMessage()], 500);
        }
    }

    public function CreateDocente(Request $request)
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
                'FK_TipoUsuario' => 'required|integer|exists:FK_TipoUsuario,Id_TipoUsuario',
                'Num_Iden' => 'required|string|max:30',
                'Password' => 'required|string|max:30',
                'Activo' => 'required|string|max:30',
                'HoraFija_Entrada' => 'required|integer',
                'HoraFija_Salida' => 'required|string|max:100',
            ]);

            // Crear persona
            $persona = Personas::create([
                'Nombres' => $validatedData['Nombres'],
                'ApellidoP' => $validatedData['ApellidoP'],
                'ApellidoM' => $validatedData['ApellidoM'],
                'Correo' => $validatedData['Correo'],
                'TipoTransporte' => $validatedData['TipoTransporte'],
            ]);

            // Crear Usuario Docente
            $User = Users::create([
                'FK_Id_Persona' => $persona->Id_Persona,
                'FK_TipoUsuario' => $validatedData['FK_TipoUsuario'],
                'Num_Iden' => $validatedData['Num_Iden'],
                'Password' => $validatedData['Password'],
                'Carrera' => $validatedData['Carrera'],
                'HoraFija_Entrada' => $validatedData['HoraFija_Entrada'],
                'HoraFija_Salida' => $validatedData['HoraFija_Salida'],
            ]);


            DB::commit();

            return redirect()->back()->with('success', 'Persona, invitado y vehículo creados con éxito');

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Error al crear persona e invitado', 'error' => $e->getMessage()], 500);
        }
    }

}
