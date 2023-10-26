<?php

namespace App\Http\Controllers;

use App\Models\Servicio;
use App\Models\ServicioArticulo;
use Illuminate\Http\Request;

class ServicioArticuloController extends Controller
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
    public function store(Servicio $servicio,Request $request)
    {
        $newArray=Array();
        foreach($request->articulos_seleccionados as $seleccionado){
            array_push($newArray,$seleccionado);
        }
        
        $servicio->ServicioArticulos()->sync($newArray);
        return response()->json([
            'status'=>true,
            'message' => 'Sección agregada correctamente'
        ],200);
        
    }

    /**
     * Display the specified resource.
     */
    public function show(ServicioArticulo $servicioArticulo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ServicioArticulo $servicioArticulo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ServicioArticulo $servicioArticulo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ServicioArticulo $servicioArticulo)
    {
        //
    }
}
