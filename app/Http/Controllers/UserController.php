<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class UserController extends Controller
{
    public function all() {
        return  User::all();
        
    }
    
    public function update(Request $request, $id) {
        $user= User::find($id);
        $validator = Validator::make($request->all(), ['name'=>'unique:users|max:20|required']);
        if ($validator->fails()) {
            return response(['message' => 'El nombre introducido ya existe o supera los 20 caractéres.'], status:400);
        }
        
       $user ->update($request->all());
         return response ([
            'user' => $user]);
    }
    
}
