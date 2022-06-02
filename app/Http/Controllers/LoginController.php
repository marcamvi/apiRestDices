<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login (Request $request){
        $credentials = $request->only('email', 'password');
        
        if (!Auth::attempt($credentials)) {
            return response([
                "message"=> "Usuario y/o contraseña incorrecto."
            ], 422);
        }
        
        $accesToken = Auth::user()->createToken('authUserToken')->accesToken;
        
        return response ([
           "user" => Auth::user(),
            "acces_token" => $accesToken
        ]);
    }
}
