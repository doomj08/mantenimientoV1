<?php

namespace App\Http\Controllers;

use App\Models\Articulo;
use App\Models\Cliente;
use App\Models\Formato;
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

    public function getInformesSelect(){
        
        $articulos=Articulo::get();
        $formatos=Formato::get();

        $select_formatos=Array();
        $select_articulos=Array();
        foreach($articulos as $articulo){
            $new_option=[
                "value"=>$articulo->id,
                "name"=>$articulo->nombre_interno,
            ];
            array_push($select_articulos,$new_option);
        }
        foreach($formatos as $formato){
            $new_option=[
                "value"=>$formato->id,
                "name"=>$formato->version,
            ];
            array_push($select_formatos,$new_option);
        }
        return response()->json([
            'status'=>true,
            'message' => 'Lista de selects para informes completada',
            'data'=>[
                'select_formatos'=>$select_formatos,
                'select_articulos'=>$select_articulos
                ]
        ],200);
    }
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
            'message' => 'Informe creado correctamente'
        ],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Informe $informe)
    {
        
        
        return response()->json([
            'status'=>true,
            'message' => 'Listado de informes descargados completamente',
            'data'=>[
                'informe'=>$informe
                ]
        ],200);
    }
    public function getPDF(Informe $informe)
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

    public function getPDFArticulo($articulo_id)
    {
        $informe=Informe::where('articulo_id',$articulo_id)->first();

        //dd($informe);
        if($informe==null){
           // return "No encontrado";
            return back()->with('status', 'Informe inexistente');
        }
        $seccionesformato=SeccionFormato::where('formato_id',$informe->formato_id)->get();
        
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
    public function update(Request $request, Informe $informe)
    {
        $informe->update($request->all());
        return response()->json([
            'status'=>true,
            'message' => 'Informe actualizado correctamente'
        ],200);
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
