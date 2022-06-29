<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Helper\HasApiResponse;
use Illuminate\Support\Facades\Auth;
//use Illuminate\Foundation\Auth\AuthenticatesUsers;


class LoginController extends Controller
{
  //  use AuthenticatesUsers;
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
        $user->logout();

        return response()->json(['Success' => 'Logged out'], 200);
    }
}
