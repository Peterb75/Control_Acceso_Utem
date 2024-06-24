<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Invitados\InvitadoController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/invitados/Peatonal', [InvitadoController::class, 'CreateInvPeatonal']);
Route::post('/invitados/Vehiculo', [InvitadoController::class, 'CreateInvVehiculo']);
