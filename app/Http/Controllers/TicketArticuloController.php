<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\TicketArticulo;
use Illuminate\Http\Request;

class TicketArticuloController extends Controller
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
    public function store(Ticket $ticket,Request $request)
    {
        $newArray=Array();
        foreach($request->articulos_seleccionados as $seleccionado){
            array_push($newArray,$seleccionado);
        }
        //$new=Ticket::with('TicketArticulo')->find($ticket->id);
        $ticket->TicketArticulo()->sync($newArray);
        
        return response()->json([
            'status'=>true,
            'message' => 'Sección agregada correctamente'
        ],200);
        //$ticket->ticket_articulos()->sync($request->articulos_seleccionados);
    }

    /**
     * Display the specified resource.
     */
    public function show(TicketArticulo $ticketArticulo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TicketArticulo $ticketArticulo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TicketArticulo $ticketArticulo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TicketArticulo $ticketArticulo)
    {
        //
    }
}
