<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/auth/login', [App\Http\Controllers\AuthController::class, 'login']);
Route::post('/register/user',[App\Http\Controllers\UserController::class, 'store']);

/* apis de cliente */

Route::apiResource('cliente',App\Http\Controllers\ClientController::class);
Route::apiResource('rifa',App\Http\Controllers\RaffleController::class);


Route::post('/sale',[App\Http\Controllers\RaffleController::class, 'saveRaffle']);

Route::get('/update/rifa/{id}/{state}',[App\Http\Controllers\RaffleController::class,'updateState']);
Route::get('/rifas/activas',[App\Http\Controllers\RaffleController::class,'rafflesStates']);
Route::get('/consulta/rifas/cliente/{id}/{option}/{datos}',[App\Http\Controllers\RaffleController::class,'consultarVenta']);
Route::get('/abono/venta/{id}/{pay}',[App\Http\Controllers\RaffleController::class,'savePay']);

Route::get('/consulta/recaudo/{id}',[App\Http\Controllers\RaffleController::class,'saleTotal']);

