<?php

namespace App\Http\Controllers;

use App\Http\Requests\ArticuloRequest;
use App\Models\Articulo;
use App\Models\TicketArticulo;
use App\Models\TipoArticulo;
use Illuminate\Http\Request;

class ArticuloController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getArticulosCliente($cliente_id=null,$ticket_id=null)
    {   
        $articulos=Articulo::with('TipoArticulo')->where('cliente_id',$cliente_id)->get();

        $values=TicketArticulo::where('ticket_id',$ticket_id)->pluck('articulo_id');

        $tipo_articulos=TipoArticulo::get();
        $select_tipo_articulos=Array();

        foreach($tipo_articulos as $tipo_articulo){
            $new_option=[
                "value"=>$tipo_articulo->id,
                "name"=>$tipo_articulo->tipo,
            ];
            array_push($select_tipo_articulos,$new_option);
        }
        return response()->json([
            'status'=>true,
            'message' => 'Lista de artículos completada',
            'data'=>[
                'articulos'=>$articulos,
                'tipo_articulos'=>$select_tipo_articulos,
                'articulos_select'=>$values
                ]
        ],200);
    }
    public function index()
    {   
        
        $articulos=Articulo::with('TipoArticulo')->get();
        $tipo_articulos=TipoArticulo::get();
        $select_tipo_articulos=Array();

        foreach($tipo_articulos as $tipo_articulo){
            $new_option=[
                "value"=>$tipo_articulo->id,
                "name"=>$tipo_articulo->tipo,
            ];
            array_push($select_tipo_articulos,$new_option);
        }
        return response()->json([
            'status'=>true,
            'message' => 'Lista de artículos completada',
            'data'=>[
                'articulos'=>$articulos,
                'tipo_articulos'=>$select_tipo_articulos
                ]
        ],200);
    }

    public function store(ArticuloRequest $request)
    {
        $articulo=Articulo::create([
            "nombre_interno"=>$request->input('nombre_interno'),
            "tipo_articulo_id"=>$request->input('tipo_articulo_id'),
            "cliente_id"=>$request->input('cliente_id')
        ]);
        return response()->json([
            'status'=>true,
            'message' => 'Artículo creado correctamente',
            
        ],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Articulo $articulo)
    {
        $tipo_articulos=TipoArticulo::get();
        $select_tipo_articulos=Array();

        foreach($tipo_articulos as $tipo_articulo){
            $new_option=[
                "value"=>$tipo_articulo->id,
                "name"=>$tipo_articulo->tipo,
            ];
            array_push($select_tipo_articulos,$new_option);
        }
        return response()->json([
            'status'=>true,
            'message' => 'Información del artículo descargado completada',
            'data'=>[
                'articulo'=>$articulo,
                'tipo_articulos'=>$select_tipo_articulos
                ]
        ],200);
    }

    public function update(ArticuloRequest $request, Articulo $articulo)
    {
        $articulo->update($request->all());

        return response()->json([
            'status'=>true,
            'message' => 'Artículo actualizado correctamente',
            'data'=>$articulo
        ],200);
    }

    public function destroy(Articulo $articulo)
    {
        $articulo->delete();
        return response()->json([
            'status'=>true,
            'message' => 'Artículo eliminado correctamente',
            'data'=>$articulo
        ],200);
    }
}
