<?php

namespace App\Http\Controllers;

use App\Http\Requests\ActividadTicketCreateRequest;
use App\Models\ActividadTicket;
use App\Models\Servicio;
use App\Models\Ticket;
use App\Models\TicketArticulo;
use Illuminate\Http\Request;

class ActividadTicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {   
        $actividadTicket=ActividadTicket::with('Ticket')->where('servicio',$id)->get();
        $ticket_id=$actividadTicket->Ticket->id;
        $articulos=TicketArticulo::with('Articulo')->where('ticket_id',$ticket_id)->get();
        $ticket=Ticket::find($id);
        $clienteId=Ticket::find($id)->cliente_id;
        return response()->json([
            'status'=>true,
            'message' => 'Lista de artículos completada',
            'data'=>[
                'ticket'=>$ticket,
                'actividades_ticket'=>$actividadTicket,
                'cliente_id'=>$clienteId,
                'articulos_ticket'=>$articulos
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
    public function store(Servicio $servicio,ActividadTicketCreateRequest $request)
    {
        

        $estado=$request->input('estado_ticket');
        if($estado)
            $estado_ticket='cerrado';
        else
            $estado_ticket='abierto';

            // return response()->json([
            //     'status'=>true,
            //     'message' => 'Actividad registrada correctamente '.$estado_ticket,
                
            // ],200);
        
        $actividadTicket=ActividadTicket::create([
            'servicio_id'=>$servicio->id,
            'ticket_id'=>$servicio->ticket_id,
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
    public function update(Request $request, $ticket, ActividadTicket $actividadTicket)
    {
        $estado=$request->input('estado_ticket');
        if($estado)
            $estado_ticket='cerrado';
        else
            $estado_ticket='abierto';
        $actividadTicket->update([
            //'servicio_id'=>$servicio->id,
            //'ticket_id'=>$servicio->ticket_id,
            'fecha_hora'=>$request->input('fecha_hora'),
            "estado_ticket"=>$estado_ticket,
            "descripcion"=>$request->input('descripcion'),
        ]);

        return response()->json([
            'status'=>true,
            'message' => 'Actividad actualizada',

        ],200);
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
