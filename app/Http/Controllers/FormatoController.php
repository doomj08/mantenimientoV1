<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Formato;
use Illuminate\Http\Request;

class FormatoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $formatos=Formato::get();

        $clientes=Cliente::get();
        $select_clientes=Array();
        foreach($clientes as $cliente){
            $new_option=[
                "value"=>$cliente->id,
                "name"=>$cliente->nombre,
            ];
            array_push($select_clientes,$new_option);
        }

        return response()->json([
            'status'=>true,
            'message' => 'Lista de artículos completada',
            'data'=>[
                'formatos'=>$formatos,
                'clientes'=>$select_clientes
                ]
        ],200);
    }

    public function store(Request $request)
    {
        $empresa_id=auth()->user()->empresa_id;
        $formato=Formato::create([
            'empresa_id'=>$empresa_id,
            'cliente_id'=>$request->cliente_id,
            'version'=>$request->version
        ]);
        return response()->json([
            'status'=>true,
            'message' => 'Coordenadas cargadas sin errores en mapas'
        ],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Formato $formato)
    {
        return response()->json([
            'status'=>true,
            'message' => 'Lista de artículos completada',
            'data'=>[
                'formato'=>$formato
                ]
        ],200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Formato $formato)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Formato $formato)
    {
        $formato->update($request->all());

        return response()->json([
            'status'=>true,
            'message' => 'Artículo actualizado correctamente',
            'data'=>$formato
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Formato $formato)
    {
        $formato->delete();
        return response()->json([
            'status'=>true,
            'message' => 'Artículo eliminado correctamente'            
        ],200);
    }
}
