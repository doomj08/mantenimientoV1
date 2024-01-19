<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Ticket;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $tickets=Ticket::with('Cliente')->withCount('Servicio','ActividadTicket')->orderBy('num_ticket')->get();
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
        $empresa_id=auth()->user()->empresa_id;
        $tecnico_id=auth()->user()->id;
        //$max_id=Ticket::where('empresa_id',$empresa_id)->max('num_ticket')+1;
        $max_id=Ticket::max('num_ticket')+1;
        $ticket=Ticket::create([
            "num_ticket"=>$max_id,
            "descripcion"=>$request->input('descripcion'),
            "cliente_id"=>$request->input('cliente_id'),
            "fecha_hora"=>$request->input('fecha_hora'),
            "fecha_estimada"=>$request->input('fecha_estimada'),
            "empresa_id"=>$empresa_id,
            'register_user_id'=>$tecnico_id
        ]);
        return response()->json([
            'status'=>true,
            'message' => 'Ticket generado correctamente '.$max_id.'...',
            
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


    public function getPDF(Ticket $ticket,$view=false)
    {
        //$empresa_id=Ticket->empresa_id;
        $tecnicos=User::with('FirmaDigitalizada')->whereHas('TecnicoActividades', function ($q) use($ticket){
            $q->where('ticket_id',$ticket->id);
        })->get();
        $encabezado=[
            'titulo1'=>'ORDEN DE SERVICIO '.$ticket->Empresa->razon_social,
            'titulo2'=>'NIT: '.$ticket->Empresa->nit,
            'titulo3'=>'Cel: '.$ticket->Empresa->telefono.'   Email:'.$ticket->Empresa->email
        ];
        
        $data=[
            "fecha_consulta"=>Carbon::now(),
            "encabezado"=>$encabezado,
            "ticket"=>$ticket,
            "tecnicos"=>$tecnicos,
            "logo"=>$ticket->Empresa->logo
        ];

        $pdf = Pdf::loadView('pdf.ticket', $data);
        $pdf->setPaper('letter', 'portrait');
        if($view)
            return $pdf->stream();
        else
            return base64_encode($pdf->stream());
        return $pdf->stream();
        //return $pdf->download('invoice.pdf');
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
    //public function update($id=null,Request $request, Ticket $ticket)
    public function update(Request $request, Ticket $ticket)
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
        DB::statement("ALTER TABLE tickets AUTO_INCREMENT = ".$ticket->count().";");
        return response()->json([
            'status'=>true,
            'message' => 'Artículo eliminado correctamente'            
        ],200);
    }

    public function showForm($uuid)
    {
        Auth::logout();
        return view('pdf.search',compact('uuid'));
    }

    public function search(Request $request,$uuid)
    {
        Auth::logout();
        $search_key=$request->input('search');
        $tickets=Ticket::with('Cliente','Empresa','Servicio.ServicioArticulos')
        ->withCount('Servicio','ActividadTicket')
        ->orderBy('num_ticket')
        ->whereHas('Cliente', function($q)  use($search_key){
            $q->where('num_documento',$search_key);
        })
        ->whereHas('Empresa', function($q)  use($uuid){
            $q->where('key_empresa',$uuid);
        })
        ->get();
        return response()->json([
            'status'=>true,
            'message' => 'Lista de tickets completada',
            'data'=>[
                'tickets'=>$tickets,
                'request'=>$request->input('search')

                ]
        ],200);
        $searchTerm = $request->input('search');
    }
}
