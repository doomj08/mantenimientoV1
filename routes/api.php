<?php

use App\Http\Controllers\ActividadTicketController;
use App\Http\Controllers\ArticuloController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CampoPropiedadController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\FormatoController;
use App\Http\Controllers\InformeController;
use App\Http\Controllers\SeccionFormatoController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TipoArticuloController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('auth/register',[AuthController::class,'create']);
Route::post('auth/login',[AuthController::class,'login']);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
}); 

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum'])->group(function (){

    Route::resource('tipo_articulos',TipoArticuloController::class);
    Route::resource('articulo',ArticuloController::class);
    Route::resource('clientes',ClienteController::class);
    Route::resource('tickets',TicketController::class);
    Route::resource('tickets.actividad_ticket',ActividadTicketController::class);
    Route::resource('informes',InformeController::class);
    Route::resource('formatos',FormatoController::class);
    Route::resource('formatos.seccion_formato',SeccionFormatoController::class);
    Route::get('seccion_formato/{seccion_formato}',[SeccionFormatoController::class,'show']);
    Route::put('seccion_formato/{seccion_formato}',[SeccionFormatoController::class,'update']);
    Route::delete('seccion_formato/{seccion_formato}',[SeccionFormatoController::class,'destroy']);

    Route::resource('tipo_articulos.campos_propiedades',CampoPropiedadController::class);
    Route::get('campos_propiedades/{campoPropiedad}',[CampoPropiedadController::class,'show']);
    Route::put('campos_propiedades/{campoPropiedad}',[CampoPropiedadController::class,'update']);
    Route::delete('campos_propiedades/{campoPropiedad}',[CampoPropiedadController::class,'destroy']);

    Route::resource('informe',InformeController::class);

    
    
    //Route::fetch('get_coordenadas',[MapaController::class,'getCoordenadas'])->name('api.coordenadas.store_fetch');
    Route::get('auth/logout',[AuthController::class,'logout']);
    
});