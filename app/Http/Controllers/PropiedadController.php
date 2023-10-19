<?php

namespace App\Http\Controllers;

use App\Models\CampoPropiedad;
use App\Models\Propiedad;
use Illuminate\Http\Request;

class PropiedadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        $propiedades=Propiedad::with('CampoPropiedad')->where('articulo_id',$id)->get();
        $camposPropiedades=CampoPropiedad::get();
        $form='';
        
        foreach($camposPropiedades as $campoPropiedad){
            $form=$form."'".$campoPropiedad->nombre_propiedad.":".null."'";
            
            
        }

        return response()->json([
            'status'=>true,
            'message' => 'Lista de artículos completada',
            'data'=>[
                'propiedades'=>$propiedades,
               // 'campos_propiedades'=>$form
                ]
        ],200);
    }

    public function store(Request $request)
    {
 
        foreach($request->campos as $key=>$campo){

            $propiedad=Propiedad::updateOrCreate(
                [
                    'campo_propiedad_id'=>$key,
                    'articulo_id'=>$request->input('articulo_id')
                ],[
                'campo_propiedad_id'=>$key,
                'propiedad'=>$campo,
                'articulo_id'=>$request->input('articulo_id')
            ]);
            
        }
        //$propiedad=Propiedad::create($request->all());
        return response()->json([
            'status'=>true,
            'message' => 'Datos actualizados correctamente'
        ],200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $propiedad=Propiedad::with('CampoPropiedad')->find($id);
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
