<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Invitados\InvitadoController;
use App\Http\Controllers\Admins\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\QRCodeController;
use App\Http\Controllers\QRController;

Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Formularios públicos
Route::view('/Tipos', 'tipo')->name('visitanos');
Route::view('/Invitado/Formulario', 'form')->name('FormVisitantes');

// Vista principal tras login (solo placeholder)
Route::get('/home', function () {
    return view('Usuarios.home');
})->middleware(['auth'])->name('home');

// --- RUTAS PROTEGIDAS ---
Route::middleware(['auth'])->group(function () {

    // 🔹 VISTA DEL USUARIO (alumno/docente): ver su QR
    Route::get('/usuario/miqr', [QRController::class, 'showMyQR'])->name('usuario.qr');

    // GUARDIAS
    Route::middleware('role:5')->group(function () {
        Route::get('/guardia', function () {
            return view('Guardias.index');
        })->name('guardia.index');
    });


    // 🔹 RUTAS DEL ADMIN
    Route::middleware('role:1')->group(function () {
        Route::get('/usuarios/activos', [AdminController::class, 'activos'])->name('activos');
        Route::get('/usuarios/inactivos', [AdminController::class, 'inactivos'])->name('inactivos');
        Route::get('/usuarios/todos', [AdminController::class, 'todos'])->name('todos');

        Route::get('/usuarios/crear', [AdminController::class, 'ShowFormUser'])->name('showformuser');
        Route::post('/usuarios/crear', [AdminController::class, 'CreateUser'])->name('CreateUser');
        Route::put('/usuarios/{id}/baja', [AdminController::class, 'BajaUser'])->name('baja');
        Route::put('/usuarios/{id}/alta', [AdminController::class, 'AltaUser'])->name('alta');
        Route::get('/usuarios/{id}/editar', [AdminController::class, 'UpdateUser'])->name('editar');

        // INVITADOS
        Route::put('/Admin/Invitado/Update', [AdminController::class, 'UpdateInvitado']);
        Route::get('/Admin/Invitados', [AdminController::class, 'ShowSolicitudes'])->name('ListSolInv');
        Route::post('/Aprovar/Solicitud', [AdminController::class, 'AceptarInv'])->name('AprovarSol');
        Route::post('/Denegar/Solicitud/{solicitudId}', [AdminController::class, 'DenegarInv'])->name('DenegarSol');
        Route::get('/Admin/Aceptados', [AdminController::class, 'ShowSolicitudesAceptados'])->name('listaceptadosinvi');
        Route::get('/Admin/Todas', [AdminController::class, 'Muestratodas'])->name('todassolid');
        Route::get('/Admin/Denegadas', [AdminController::class, 'ShowSolicDenegadas'])->name('listdenegadas');
    });
});
