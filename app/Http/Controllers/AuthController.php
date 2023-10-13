<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserRequest;
use App\Models\User;
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
        $user = User::where('email',$request->email)->first();
        return response()->json([   
            'status'=>true,
            'message'=>'User logged is successfull',
            'user'=> $user,
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
