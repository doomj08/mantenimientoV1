<?php

namespace App\Http\Controllers;

use App\Http\Requests\ActividadTicketCreateRequest;
use App\Models\ActividadTicket;
use App\Models\Ticket;
use Illuminate\Http\Request;

class ActividadTicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {   
        $actividadTicket=ActividadTicket::with('Ticket')->where('ticket_id',$id)->get();
        $clienteId=Ticket::find($id)->cliente_id;
        return response()->json([
            'status'=>true,
            'message' => 'Lista de artículos completada',
            'data'=>[
                'actividades_ticket'=>$actividadTicket,
                'cliente_id'=>$clienteId
                ]
        ],200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Ticket $ticket,ActividadTicketCreateRequest $request)
    {
        if($request->input('estado_ticket'))
            $estado_ticket='Cerrado';
        else
            $estado_ticket='Abierto';
        
        $actividadTicket=ActividadTicket::create([
            'ticket_id'=>$ticket->id,
            'fecha_hora'=>$request->input('fecha_hora'),
            "estado_ticket"=>$estado_ticket,
            "descripcion"=>$request->input('descripcion'),
        ]);
        return response()->json([
            'status'=>true,
            'message' => 'Actividad registrada correctamente',
            
        ],200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id,ActividadTicket $actividadTicket)
    {
        
        return response()->json([
            'status'=>true,
            'message' => 'Lista de artículos completada',
            'data'=>[
                'actividad_ticket'=>$actividadTicket,
                ]
        ],200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ActividadTicket $actividadTicket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ActividadTicket $actividadTicket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id,ActividadTicket $actividadTicket)
    {
        $actividadTicket->delete();
        return response()->json([
            'status'=>true,
            'message' => 'actividadTicket eliminada',
            'data'=>$actividadTicket
        ],200);
    }
}
