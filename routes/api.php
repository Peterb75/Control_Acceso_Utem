<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Invitados\InvitadoController;
use App\Http\Controllers\Admins\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\RegistrosGeneral\RegistrosController;
use App\Http\Controllers\QrCodeController;
use App\Http\Controllers\QRController;
use App\Http\Controllers\ExcelController;

Route::get('/export-solicitudes', [ExcelController::class, 'exportSolicitudes'])->name('export.solicitudes');

Route::post('/verify-qr', [QRController::class, 'verifyQR']);

Route::post('/generate-qr', [QrCodeController::class, 'generate']);
Route::get('/qr-code/{id}', [QrCodeController::class, 'show']);

Route::post('/Invitado', [InvitadoController::class, 'createInvitado'])->name('CrearInv');

Route::get('/Invitados/{Nombre}', [AdminController::class, 'showInvitadosName'])->name('BusquedaInv');
Route::post('Admin/Users/Create', [AdminController::class, 'CreateUser']);

// Rutas autenticadas
Route::middleware('auth')->group(function () {
    // Rutas para administradores
    Route::middleware('role:1')->group(function () {
        //Invitados / Solicitudes
        /*Route::post('Aprovar/Solicitud', [AdminController::class, 'AceptarInv'])->name('AprovarSol');
        Route::delete('/Denegar/Solicitud/{solicitudId}', [AdminController::class, 'DenegarInv'])->name('DenegarSol');

        //Usuarios
        //Route::get('/Admin/Invitados', [AdminController::class, 'ShowSolicitudes'])->name('ListSolInv');    
*/
        Route::get('/Users', [AdminController::class, 'UsersAll']);
        Route::get('/Users/{Num_Iden}', [AdminController::class, 'Users']);
        //Route::put('/Admin/Invitado/Update', [AdminController::class, 'UpdateInvitado']);
        Route::get('/Admin/Users/Type', [AdminController::class, 'TipoUser']);
        Route::put('Admin/Users/Update', [AdminController::class, 'UpdateUser']);
        Route::put('/Baja/{id}', [AdminController::class, 'BajaUser']);
        Route::put('/Alta/{id}', [AdminController::class, 'AltaUser']);
    });

    //Guardias de entrada y salida
    Route::middleware('role:5')->group( function () {
        Route::post('/RegsitroEntrada', [RegistrosController::class, 'REntrada']);
        Route::post('/RegistroSalida', [RegistrosController::class, 'RSalida']);
    });
});

?>