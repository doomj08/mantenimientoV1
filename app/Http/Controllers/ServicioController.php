<?php

namespace App\Http\Controllers;

use App\Models\ActividadTicket;
use App\Models\Servicio;
use App\Models\Ticket;
use App\Models\TicketArticulo;
use Illuminate\Http\Request;

class ServicioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {   
        //dd($id);
        
        
        
        $ticket=Ticket::where('num_ticket',$id)->first();

        $clienteId=$ticket->cliente_id;
        $actividadTicket=ActividadTicket::with('Ticket')->where('ticket_id',$ticket->id)->get();
        $servicioTicket=Servicio::with('ServicioArticulos')->where('ticket_id',$ticket->id)->get();
        $articulos=TicketArticulo::with('Articulo')->where('ticket_id',$ticket->id)->get();
        return response()->json([
            'status'=>true,
            'message' => 'Lista de servicios completada',
            'data'=>[
                'servicios'=>$servicioTicket,
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Servicio $servicio)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Servicio $servicio)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Servicio $servicio)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Servicio $servicio)
    {
        //
    }
}
