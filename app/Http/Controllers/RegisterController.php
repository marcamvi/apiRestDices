<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class RegisterController extends Controller
{
        
    
    public function register (Request $request) {
        if ($request['name']==null) {
            
            $validatedData=$request->validate(['email' => 'unique:users|required|email', 'password' => 'required|confirmed', 'name'=>'nullable', 'role' => 'required']);
            $validatedData['name']='Anónimo';
        } else {
            $validatedData =$request->validate(['name'=>'unique:users|max:20' , 'email' => 'unique:users|required|email', 'password' => 'required|confirmed', 'role' => 'required']);
        }
    


            
        $validatedData['password'] = Hash::make($request->password);
        
        $user = User::create($validatedData);
        
        $accesToken = $user->createToken('authToken')->accessToken;
        
        return response (['message' => 'Usuario '.$user['name'].' creado con éxito.']);
        
    }
}
