<?php

namespace App\Http\Controllers;

use App\Models\Formato;
use App\Models\SeccionFormato;
use Illuminate\Http\Request;

class SeccionFormatoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        $seccionFormato=SeccionFormato::where('formato_id',$id)->get();
        return response()->json([
            'status'=>true,
            'message' => 'Lista de artículos completada',
            'data'=>[
                'secciones_formato'=>$seccionFormato
                ]
        ],200);
    }

    public function store(Formato $formato, Request $request)
    {
        $seccionFormato=SeccionFormato::create([
            'formato_id'=>$formato->id,
            'seccion'=>$request->seccion,
            'order'=>1
        ]);
        return response()->json([
            'status'=>true,
            'message' => 'Coordenadas cargadas sin errores en mapas'
        ],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(SeccionFormato $seccionFormato)
    {
        return response()->json([
            'status'=>true,
            'message' => 'Sección descargada',
            'data'=>[
                'seccion_formato'=>$seccionFormato
                ]
        ],200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SeccionFormato $seccionFormato)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SeccionFormato $seccionFormato)
    {
        $seccionFormato->update($request->all());

        return response()->json([
            'status'=>true,
            'message' => 'Artículo actualizado correctamente',
            'data'=>$seccionFormato
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SeccionFormato $seccionFormato)
    {
        $seccionFormato->delete();
        return response()->json([
            'status'=>true,
            'message' => 'Artículo eliminado correctamente'            
        ],200);
    }
}
