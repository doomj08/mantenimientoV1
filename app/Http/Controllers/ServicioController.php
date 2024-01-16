<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServicioCreateRequest;
use App\Models\ActividadTicket;
use App\Models\Servicio;
use App\Models\Ticket;
use App\Models\TicketArticulo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $servicioTicket=Servicio::with('Pagos','ServicioArticulos','Actividades')->where('ticket_id',$ticket->id)->get();
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
    public function store($ticket_id,ServicioCreateRequest $request)
    {
        $servicio=Servicio::create([
            'ticket_id'=>$ticket_id,
            'user_id'=>auth()->user()->id,
            'descripcion'=>$request->descripcion,
            'fecha_programada'=>$request->fecha_programada,
            'fecha_inicio'=>$request->fecha_inicio,
            'fecha_fin'=>$request->fecha_fin,
            'precio'=>$request->precio,
        ]);

        return response()->json([
            'status'=>true,
            'message' => 'Servicio agregado'
        ],200);
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
    public function edit($ticket_id,Servicio $servicio)
    {
        return response()->json([
            'status'=>true,
            'message' => 'Lista de servicios completada',
            'data'=>[
                'servicio'=>$servicio
                ]
        ],200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($ticket_id,Request $request, Servicio $servicio)
    {
        $servicio->update([
            //'ticket_id'=>$servicio->ticket_id,
            'user_id'=>auth()->user()->id,
            'descripcion'=>$request->descripcion,
            'fecha_programada'=>$request->fecha_programada,
            'fecha_inicio'=>$request->fecha_inicio,
            'fecha_fin'=>$request->fecha_fin,
            'precio'=>$request->precio,

        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($ticket_id,Servicio $servicio)
    {
        $servicio->delete();
        DB::statement("ALTER TABLE servicios AUTO_INCREMENT = ".$servicio->count().";");
        return response()->json([
            'status'=>true,
            'message' => 'Artículo eliminado correctamente'            
        ],200);
    }
}
