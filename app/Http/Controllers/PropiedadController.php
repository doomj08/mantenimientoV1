<?php

namespace App\Http\Controllers;

use App\Models\Propiedad;
use Illuminate\Http\Request;

class PropiedadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $propiedades=Propiedad::get();
        return response()->json([
            'status'=>true,
            'message' => 'Lista de artículos completada',
            'data'=>[
                'propiedades'=>$propiedades
                ]
        ],200);
    }

    public function store(Request $request)
    {
        $propiedad=Propiedad::create($request->all());
        return response()->json([
            'status'=>true,
            'message' => 'Coordenadas cargadas sin errores en mapas'
        ],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Propiedad $propiedad)
    {
        return response()->json([
            'status'=>true,
            'message' => 'Lista de artículos completada',
            'data'=>[
                'propiedad'=>$propiedad
                ]
        ],200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Propiedad $propiedad)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Propiedad $propiedad)
    {
        $propiedad->update($request->all());

        return response()->json([
            'status'=>true,
            'message' => 'Artículo actualizado correctamente',
            'data'=>$propiedad
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Propiedad $propiedad)
    {
        $propiedad->delete();
        return response()->json([
            'status'=>true,
            'message' => 'Artículo eliminado correctamente'            
        ],200);
    }
}
