<?php

namespace App\Http\Controllers;

use App\Models\TipoArticulo;
use Illuminate\Http\Request;

class TipoArticuloController extends Controller
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
    public function store(Request $request)
    {
        $tipo=TipoArticulo::create($request);
        return $tipo;
    }

    /**
     * Display the specified resource.
     */
    public function show(TipoArticulo $tipoArticulo)
    {
        return $tipoArticulo;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TipoArticulo $tipoArticulo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TipoArticulo $tipoArticulo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TipoArticulo $tipoArticulo)
    {
        //
    }
}
