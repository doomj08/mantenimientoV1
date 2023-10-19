<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tickets=Ticket::with('Cliente')->withCount('ActividadTicket')->get();
        return response()->json([
            'status'=>true,
            'message' => 'Lista de tickets completada',
            'data'=>[
                'tickets'=>$tickets
                ]
        ],200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
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
            'message' => 'Lista de tickets completada',
            'data'=>[
                'clientes'=>$select_clientes
                ]
        ],200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $ticket=Ticket::create([
            "descripcion"=>$request->input('descripcion'),
            "cliente_id"=>$request->input('cliente_id'),
        ]);
        return response()->json([
            'status'=>true,
            'message' => 'Ticket generado correctamente',
            
        ],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
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
            'message' => 'Información del artículo descargado completada',
            'data'=>[
                'ticket'=>$ticket,
                'clientes'=>$select_clientes
                ]
        ],200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ticket $ticket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id,Request $request, Ticket $ticket)
    {
        $ticket->update($request->all());
        return response()->json([
            'status'=>true,
            'message' => 'Categoría actualizada correctamente',
            'data'=>[
                'ticket'=>$ticket
                ]
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
        $ticket->delete();
        return response()->json([
            'status'=>true,
            'message' => 'Artículo eliminado correctamente'            
        ],200);
    }
}
