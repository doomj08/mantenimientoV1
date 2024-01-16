<?php

namespace App\Http\Controllers;

use App\Models\TicketRecomendacion;
use Illuminate\Http\Request;

class TicketRecomendacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store($ticket_id,Request $request)
    {

        $ticketRecomendacion=TicketRecomendacion::create([
            'ticket_id'=>$ticket_id,
            'user_id'=>auth()->user()->id,
            'recomendacion'=>$request->recomendacion
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(TicketRecomendacion $ticketRecomendacion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($ticket_id,$ticketRecomendacionId)
    {
        
        $ticketRecomendacion=TicketRecomendacion::find($ticketRecomendacionId);
        return response()->json([
            'status'=>true,
            'message' => 'Lista de recomendaciones completada',
            'data'=>[
                'recomendacion'=>$ticketRecomendacion
                ]
        ],200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$ticket_id, $ticketRecomendacionId)
    {
        $ticketRecomendacion=TicketRecomendacion::find($ticketRecomendacionId);
        $ticketRecomendacion->update([
            'user_id'=>auth()->user()->id,
            'recomendacion'=>$request->recomendacion
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TicketRecomendacion $ticketRecomendacion)
    {
        //
    }
}
