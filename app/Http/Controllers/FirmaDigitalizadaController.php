<?php

namespace App\Http\Controllers;

use App\Models\FirmaDigitalizada;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Response;

class FirmaDigitalizadaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user=Auth::user();
        $firma = FirmaDigitalizada::where('user_id',$user->id)->latest()->first();
        return response()->json([   
            'status'=>true,
            
            
            'firma_mano_alzada'=> $firma,
            
        ],200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user=Auth::user();
        $firma = FirmaDigitalizada::where('user_id',$user->id)->latest()->first();
        return response()->json([   
            'status'=>true,
            
            
            'firma_mano_alzada'=> $firma,
            
        ],200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)//:RedirectResponse
    {
        FirmaDigitalizada::create([
            'user_id'=>Auth::id(),
            'firma_digital' => $request->firma_digital
        ]);
        $user=Auth::user();
        $firma = FirmaDigitalizada::where('user_id',$user->id)->latest()->first();
        return response()->json([
            'status'=>true,
            'message' => 'Firma creada correctamente',
            'firma_mano_alzada'=> $firma,
        ],200);
        //return redirect()->route('profile.edit');

    }

    /**
     * Display the specified resource.
     */
    public function show(FirmaDigitalizada $firmaDigitalizada)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FirmaDigitalizada $firmaDigitalizada)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FirmaDigitalizada $firmaDigitalizada)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FirmaDigitalizada $firmaDigitalizada)
    {
        //
    }
}
