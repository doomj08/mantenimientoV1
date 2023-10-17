<?php

namespace App\Http\Controllers;

use App\Models\Articulo;
use App\Models\Informe;
use App\Models\SeccionFormato;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class InformeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $informes=Informe::get();
        return response()->json([
            'status'=>true,
            'message' => 'Lista de artículos completada',
            'data'=>[
                'informes'=>$informes
                ]
        ],200);
    }

    public function store(Request $request)
    {
        $informe=Informe::create($request->all());
        return response()->json([
            'status'=>true,
            'message' => 'Coordenadas cargadas sin errores en mapas'
        ],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Informe $informe)
    {
        $seccionesformato=SeccionFormato::where('formato_id',1)->get();
        
        $data=[
            "fecha_consulta"=>Carbon::now(),
            "articulo"=>$informe->articulo,
            "seccionesformato"=>$seccionesformato
        ];
        $pdf = Pdf::loadView('pdf.invoice', $data);
        $base64 = base64_encode($pdf->stream());
        return $pdf->stream();
        //return $pdf->download('invoice.pdf');
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
    public function destroy(Informe $informe)
    {
        $informe->delete();
        return response()->json([
            'status'=>true,
            'message' => 'Artículo eliminado correctamente'            
        ],200);
    }
}
