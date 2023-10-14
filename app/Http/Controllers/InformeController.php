<?php

namespace App\Http\Controllers;

use App\Models\Articulo;
use App\Models\Informe;
use App\Models\SeccionFormato;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class InformeController extends Controller
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Informe $informe)
    {
        //$informe=Informe::with('Articulo.Propiedad.CampoPropiedad','Articulo.Componente.Propiedad.CampoPropiedad')->find($id);
        //$articulo=Articulo::with('Propiedad.CampoPropiedad','Componente.Propiedad.CampoPropiedad')->find($id);
        $seccionesformato=SeccionFormato::where('formato_id',1)->get();
        //dd($articulo->Componente);
        $data=[
            "fecha_consulta"=>Carbon::now(),
            "articulo"=>$informe->articulo,
            "seccionesformato"=>$seccionesformato
        ];
        $pdf = Pdf::loadView('pdf.invoice', $data);
        return $pdf->stream();
        return $pdf->download('invoice.pdf');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
