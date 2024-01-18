<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClienteCreateRequest;
use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clientes=Cliente::get();
        return response()->json([
            'status'=>true,
            'message' => 'Lista de clientes completada',
            'data'=>[
                'clientes'=>$clientes
                ]
        ],200);
    }

    public function store(ClienteCreateRequest $request)
    {
        $empresa_id=auth()->user()->empresa_id;
        $cliente=Cliente::create(
            [
                'empresa_id'=>$empresa_id,
                'nombre'=>$request->nombre,
                'tipo_documento'=>$request->tipo_documento,
                'num_documento'=>$request->num_documento,
                'contacto'=>$request->contacto,
                'correo'=>$request->correo,
                'telefono'=>$request->telefono,
                'direccion'=>$request->direccion,
                'ciudad'=>$request->ciudad
            ]
        );
        return response()->json([
            'status'=>true,
            'message' => 'Cliente creado correctamente',
            'data'=>[
                'cliente'=>$cliente,
                ]
        ],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Cliente $cliente)
    {
        return response()->json([
            'status'=>true,
            'message' => 'Lista de artículos completada',
            'data'=>[
                'cliente'=>$cliente
                ]
        ],200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cliente $cliente)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ClienteCreateRequest $request, Cliente $cliente)
    {
        $cliente->update($request->all());

        return response()->json([
            'status'=>true,
            'message' => 'Cliente actualizado correctamente',
            'data'=>$cliente
            
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cliente $cliente)
    {
        $cliente->delete();
        return response()->json([
            'status'=>true,
            'message' => 'Cliente eliminado correctamente'            
        ],200);
    }
}
