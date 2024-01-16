<?php

namespace App\Http\Controllers;

use App\Models\ServicioPago;
use Illuminate\Http\Request;

class ServicioPagoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
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
    public function store($ticket_id,$servicio_id,Request $request)
    {
        $newPago=ServicioPago::create([
            'servicio_id'=>$servicio_id,
            'fecha'=>$request->fecha,
            'tipo_pago'=>$request->tipo_pago,
            'referencia'=>$request->referencia,
            'concepto'=>$request->concepto,
            'valor'=>$request->valor,
        ]);
        
    }

    /**
     * Display the specified resource.
     */
    public function show($ticket_id,$servicio_id, $servicioPagoId)
    {
        $servicioPago=ServicioPago::find($servicioPagoId);
        return response()->json([
            'status'=>true,
            'message' => 'Pagos descargados correctamente',
            'data'=>[
                'servicio_pago'=>$servicioPago,
                'ticket'=>$ticket_id,
                'servicio'=>$servicio_id
                ]
        ],200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ServicioPago $servicioPago)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$ticket_id,$servicio_id,$servicioPagoId)
    {
        $servicioPago=ServicioPago::find($servicioPagoId);
        $servicioPago->update([
            'fecha'=>$request->fecha,
            'tipo_pago'=>$request->tipo_pago,
            'referencia'=>$request->referencia,
            'concepto'=>$request->concepto,
            'valor'=>$request->valor
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ServicioPago $servicioPago)
    {
        //
    }
}
