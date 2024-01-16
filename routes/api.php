<?php

use App\Http\Controllers\ActividadTicketController;
use App\Http\Controllers\ArticuloController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CampoPropiedadController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\FirmaDigitalizadaController;
use App\Http\Controllers\FormatoController;
use App\Http\Controllers\InformeController;
use App\Http\Controllers\PropiedadController;
use App\Http\Controllers\SeccionFormatoController;
use App\Http\Controllers\ServicioArticuloController;
use App\Http\Controllers\ServicioPagoController;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\TicketArticuloController;
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
    Route::resources([
        'firma_digitalizada'=>FirmaDigitalizadaController::class,
    ]);


    Route::get('pdf/ticket/{ticket}',[TicketController::class,'getPDF']);
    Route::resource('tipo_articulos',TipoArticuloController::class);
    Route::resource('articulo',ArticuloController::class);
    Route::resource('clientes',ClienteController::class);
    Route::resource('propiedad',PropiedadController::class);
    Route::resource('articulo.propiedad',PropiedadController::class);
 
    Route::resource('tickets.servicio.pago',ServicioPagoController::class);
    Route::resource('tickets.servicio',ServicioController::class);
    Route::resource('tickets.recomendacion',ServicioController::class);
    Route::resource('tickets',TicketController::class);
    Route::resource('tickets.actividad_ticket',ActividadTicketController::class);
    
    Route::resource('tickets.articulos',TicketArticuloController::class);

    

    // Route::get('add_actividad/{ticket}/',[ActividadTicketController::class,'store']);
    // Route::post('add_actividad/{ticket}/',[ActividadTicketController::class,'store']);

    Route::get('add_actividad/{servicio}/',[ActividadTicketController::class,'store']);
    Route::post('add_actividad/{servicio}/',[ActividadTicketController::class,'store']);

    Route::put('edit_actividad/{ticket}/{actividad_ticket}',[ActividadTicketController::class,'update']);
    Route::post('edit_actividad/{ticket}/{actividad_ticket}',[ActividadTicketController::class,'update']);
    Route::delete('delete_actividad/{ticket}/{actividad_ticket}',[ActividadTicketController::class,'destroy']);

    // Route::get('add_articulo/{ticket}/',[TicketArticuloController::class,'store']);
    // Route::post('add_articulo/{ticket}/',[TicketArticuloController::class,'store']);

    Route::get('add_articulo/{servicio}/',[ServicioArticuloController::class,'store']);
    Route::post('add_articulo/{servicio}/',[ServicioArticuloController::class,'store']);

    

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

    //Route::get('articulos_cliente/{cliente_id}/{ticket_id?}',[ArticuloController::class,'getArticulosCliente']);
    Route::get('articulos_cliente/{cliente_id}/{servicio_id?}',[ArticuloController::class,'getArticulosCliente']);
    Route::get('articulos_select',[ArticuloController::class,'getArticulosSelect']);
    Route::get('informes_select',[InformeController::class,'getInformesSelect']);
    Route::post('articulos_cliente/{ticket_id}',[ArticuloController::class,'getArticulosCliente']);

    Route::resource('informe',InformeController::class);

    
    
    //Route::fetch('get_coordenadas',[MapaController::class,'getCoordenadas'])->name('api.coordenadas.store_fetch');
    Route::get('auth/logout',[AuthController::class,'logout']);
    
});