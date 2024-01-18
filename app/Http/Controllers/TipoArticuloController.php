<?php

namespace App\Http\Controllers;

use App\Http\Requests\TipoArticuloCreateRequest;
use App\Models\TipoArticulo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

use App\Models\Cliente;
use App\Models\Ticket;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TipoArticuloController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    //private $empresa_id=auth()->user()->empresa_id;
    public function index()
    {
        $tipoArticulos=TipoArticulo::get();
        return response()->json([
            'status'=>true,
            'message' => 'Lista de categorías completada',
            'data'=>[
                'tipo_articulos'=>$tipoArticulos
                ]
        ],200);
    }

    public function store(TipoArticuloCreateRequest $request)
    {
        //return response(auth()->user()->empresa_id);
        $empresa_id=auth()->user()->empresa_id;
        $tipo=TipoArticulo::create([
            'empresa_id'=>$empresa_id,
            'tipo'=>$request->tipo
            ]
        );
        return response()->json([
            'status'=>true,
            'message' => 'Coordenadas cargadas sin errores en mapas',
            
        ],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(TipoArticulo $tipoArticulo)
    {
        return response()->json([
            'status'=>true,
            'message' => 'Información del artículo descargado completada',
            'data'=>[
                'tipo_articulo'=>$tipoArticulo
                ]
        ],200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TipoArticulo $tipoArticulo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TipoArticulo $tipoArticulo)
    {
        $tipoArticulo->update($request->all());
        return response()->json([
            'status'=>true,
            'message' => 'Categoría actualizada correctamente',
            'data'=>[
                'tipo_articulo'=>$tipoArticulo
                ]
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TipoArticulo $tipoArticulo)
    {
        $tipoArticulo->delete();
        return response()->json([
            'status'=>true,
            'message' => 'Artículo eliminado correctamente'            
        ],200);
    }
}
