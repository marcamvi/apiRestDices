<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller {

    public function all() {
        if (Auth::user()->role != "1") {
            return response(['message' => 'No tienes permiso para acceder a este apartado.'], status: 403);
        } else {
            return $users = User::all();
        }
    }

    public function update(Request $request, $id) {
        $userAuth = Auth::user()->id;
        
        if ($userAuth == $id) {
            $user = User::find($id);
            $validator = Validator::make($request->all(), ['name' => 'unique:users|max:20|required']);
            if ($validator->fails()) {
                return response(['message' => 'El nombre introducido ya existe o supera los 20 caractéres.'], status: 400);
        } 
            }elseif (!User::find($id)) {
                return response([
                    "message" => "El usuario seleccionado no existe."
                        ], 422);
            } else {
                return response([
                    "message" => "Usuario no autorizado."
                        ], 401);
            }
            $user->update($request->all());
            return response([
                'user' => $user]);
        
    }

}
