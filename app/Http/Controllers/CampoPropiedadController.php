<?php

namespace App\Http\Controllers;

use App\Models\CampoPropiedad;
use App\Models\SeccionFormato;
use Illuminate\Http\Request;

class CampoPropiedadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id=null)
    {
        $campoPropiedad=CampoPropiedad::where('tipo_articulo_id',$id)->get();
        $allSecciones=SeccionFormato::withCount('CampoPropiedad')->get();
        $secciones=SeccionFormato::with('CampoPropiedad')->withCount('CampoPropiedad')->whereHas('CampoPropiedad', function($q) use($id){
            return $q->where('tipo_articulo_id', $id);
        })->get();
        return response()->json([
            'status'=>true,
            'message' => 'Lista de campos completada '.$id,
            'data'=>[
                'campo_propiedad'=>$campoPropiedad,
                'secciones'=>$secciones,
                'all_secciones'=>$allSecciones
                ]
        ],200);
    }

    public function store(Request $request)
    {
        $campoPropiedad=CampoPropiedad::create($request->all());
        return response()->json([
            'status'=>true,
            'message' => 'Coordenadas cargadas sin errores en mapas'
        ],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(CampoPropiedad $campoPropiedad)
    {
        return response()->json([
            'status'=>true,
            'message' => 'Lista de artículos completada',
            'data'=>[
                'campo_propiedad'=>$campoPropiedad
                ]
        ],200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CampoPropiedad $campoPropiedad)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CampoPropiedad $campoPropiedad)
    {
        $campoPropiedad->update(['nombre_propiedad'=>$request->nombre_propiedad]);

        return response()->json([
            'status'=>true,
            'message' => 'Artículo actualizado correctamente',
            'data'=>$campoPropiedad
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CampoPropiedad $campoPropiedad)
    {
        $campoPropiedad->delete();
        return response()->json([
            'status'=>true,
            'message' => 'Campo eliminado correctamente'            
        ],200);
    }
}
