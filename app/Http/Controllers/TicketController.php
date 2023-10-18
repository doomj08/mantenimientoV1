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
        //
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
    public function update(Request $request, Ticket $ticket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
        //
    }
}
