<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Helper\HasApiResponse;
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
        
        $accessToken = Auth::user()->createToken('authUserToken')->accessToken;
        
        return response ([
           "user" => Auth::user(),
           "access_token" => $accessToken
        ]);
    }
    public function logout(User $user)
    {
        $user = Auth::user()->token();
        $user->revoke();

        return response(['message' => 'Te has desconectado con éxito.'], 200);
    }
}
