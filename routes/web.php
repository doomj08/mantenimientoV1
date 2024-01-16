<?php

use App\Http\Controllers\ArticuloController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InformeController;
use App\Http\Controllers\PropiedadController;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/*', function () {
    return view('welcome');
});

Route::get('/informe', function () {
    return view('welcome');
});

//Route::resource('informe',InformeController::class);

Route::get('informe/{informe}',[InformeController::class,'getPDF']);
Route::get('/pdf/ticket/{ticket}/{view?}',[TicketController::class,'getPDF']);
Route::get('/pdf/informe/{articulo}',[InformeController::class,'getPDFArticulo']);
Route::get('/search/ticket/',[TicketController::class,'search_index']);
Route::post('/search/ticket/',[TicketController::class,'search_show']);

// Muestra el formulario
Route::get('/search', [TicketController::class, 'showForm'])->name('search.form');

// Procesa la búsqueda
Route::post('/search', [TicketController::class, 'search'])->name('search');


Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('config:clear');
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('config:cache');
    return 'DONE'; //Return anything
});

Route::get('/migrate', function() {
    $exitCode = Artisan::call('migrate');
    return 'DONE'; //Return anything
});
Route::get('/rollback', function() {
    $exitCode = Artisan::call('rollback');
    return 'DONE'; //Return anything
});

Route::get('/sello', function() {
    return view('pdf.sello');
    return 'DONE'; //Return anything
});
Auth::routes();

//Route::get('/', [HomeController::class, 'index'])->name('home');
Route::any('{any?}', [HomeController::class, 'index'])->name('home');
//Route::resource('tickets.servicio',ServicioController::class);