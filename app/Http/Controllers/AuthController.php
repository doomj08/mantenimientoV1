<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserRequest;
use App\Models\FirmaDigitalizada;
use App\Models\User;
use App\Models\Empresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function create(UserRequest $request){
        $user= User::create([
            'name'=> $request->name,
            'email'=> $request->email,
            'password'=> Hash::make($request->password)
        ]);
        return response()->json([
            'status'=>true,
            'message' => 'User created successfull',
            'token' => $user->createToken('API TOKEN')->plainTextToken
        ],200);
    }

    public function login(LoginRequest $request){
        if(!Auth::attempt($request->only('email','password'))){
            return response()->json([
                'status'=>false,
                'errors'=>['Unauthorized']
            ],401);
        }
        $user = User::with('Empresa')->where('email',$request->email)->first();
        $firma = FirmaDigitalizada::where('user_id',$user->id)->latest()->first();
        $logo = $user->Empresa->logo;
        return response()->json([   
            'status'=>true,
            'message'=>'User logged is successfull',
            'user'=> $user,
            'firma_mano_alzada'=> $firma,
            'logo'=>$logo,
            'token'=> $user->createToken('API TOKEN')->plainTextToken
        ],200);
    }

    public function logout(){
        auth()->user()->tokens()->delete();
        return response()->json([
            'status'=>true,
            'message'=>'User logged'
        ],200);
    }
}
