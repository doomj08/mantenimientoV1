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
        $cliente=Cliente::create($request->all());
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
    public function update(Request $request, Cliente $cliente)
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
