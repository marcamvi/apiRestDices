<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Game;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GameController extends Controller {

    public function store($id) {
        $userAuth = Auth::user()->id;
        if ($userAuth == $id) {
            $dice1 = rand(1, 6);
            $dice2 = rand(1, 6);
            $throw = new Game;
            $throw->Tirada_Uno = $dice1;
            $throw->Tirada_Dos = $dice2;
            $throw->user_id = $id;
            if (($dice1 + $dice2) == 7) {
                $throw->Derrota_Victoria = 1; //Victoria
            } else {
                $throw->Derrota_Victoria = 0; //Derrota
            }
            $throw->save();
            return $throw;
        } elseif (!User::find($id)) {
            return response([ "message" => "El usuario seleccionado no existe."], 422);
        } else {
            return response([ "message" => "Usuario no autorizado."], 403);
        }
    }

    public function delete($id) {
        $findGame = Game::where('user_id', $id)->first('id');
        $userAuth = Auth::user()->id;
        if ($userAuth == $id && $findGame !== null) {
            $deleted = Game::where('user_id', $id)->delete();
            $userName = user::find($id)->name;
            return response([
                "message" => "Las jugadas del usuario $userName han sido eliminadas del sistema."], 200);
        } elseif (!User::find($id)) {
            return response([
                "message" => "El usuario seleccionado no existe."], 422);
        } elseif ($findGame == null) {
            return response([
                "message" => "El usuario seleccionado no tiene jugadas disponibles para eliminar."], 422);
        } else {
            return response([
                "message" => "Usuario no autorizado."], 401);
        }
    }

    public function show($id, Game $game) {
        $findGame = Game::where('user_id', $id)->first('id');

        $userAuth = Auth::user()->id;
        if ($userAuth == $id && $findGame !== null) {
            return Game::where('user_id', $id)->get();
        } elseif (!User::find($id)) {
            return response([
                "message" => "El usuario seleccionado no existe."
                    ], 422);
        } elseif ($findGame == null) {
            return response([
                "message" => "El usuario seleccionado no tiene jugadas disponibles para mostrar."
                    ], 422);
        } else {
            return response([
                "message" => "Usuario no autorizado."
                    ], 401);
        }
    }

    public function successRate(User $user, Game $game) {
        if (Auth::user()->role != "1") {
            return response(['message' => 'No tienes permiso para acceder a este apartado.'], status: 403);
        } else {
            $rate = DB::table('games')
                            ->selectraw('users.name as Nombre, COUNT(games.Derrota_Victoria) as Total_partidas, ROUND(100*SUM(games.Derrota_Victoria=1)/COUNT(games.Derrota_Victoria)) as Porcentaje_Victorias, ROUND(100*SUM(games.Derrota_Victoria=0)/COUNT(games.Derrota_Victoria))as Porcentaje_Derrotas')->join('users', 'games.user_id', '=', 'users.id')->groupby('users.name')->get();

            return $rate;
        }
    }

    public function ranking(Game $game) {

        if (Auth::user()->role != "1") {
            return response(['message' => 'No tienes permiso para acceder a este apartado.'], status: 403);
        } else {
            $totalRate = DB::table('games')->selectraw('users.name as Nombre, COUNT(games.user_id) as Total_Victorias, ROUND(100*COUNT(games.Derrota_Victoria)/(SELECT COUNT(games.Derrota_Victoria) FROM games WHERE games.Derrota_Victoria=1)) as Porcentaje_total')->where('games.Derrota_Victoria', '=', 1)->join('users', 'games.user_id', '=', 'users.id')->orderby('Porcentaje_total', 'desc')->groupby('users.name')->get();

            return $totalRate;
        }
    }

    public function rankingLoser(Game $game) {

        if (Auth::user()->role != "1") {
            return response(['message' => 'No tienes permiso para acceder a este apartado.'], status: 403);
        } else {
            $totalRate = DB::table('games')->selectraw('users.name as Nombre, COUNT(games.user_id) as Total_Victorias, ROUND(100*COUNT(games.Derrota_Victoria)/(SELECT COUNT(games.Derrota_Victoria) FROM games WHERE games.Derrota_Victoria=1)) as Porcentaje_total')->where('games.Derrota_Victoria', '=', 1)->join('users', 'games.user_id', '=', 'users.id')->orderby('Porcentaje_total', 'asc')->groupby('users.name')->limit(1)->get();

            return $totalRate;
        }
    }

    public function rankingWinner(Game $game) {

        if (Auth::user()->role !== "1") {
            return response(['message' => 'No tienes permiso para acceder a este apartado.'], status: 403);
        } else {
            $totalRate = DB::table('games')->selectraw('users.name as Nombre, COUNT(games.user_id) as Total_Victorias, ROUND(100*COUNT(games.Derrota_Victoria)/(SELECT COUNT(games.Derrota_Victoria) FROM games WHERE games.Derrota_Victoria=1)) as Porcentaje_total')->where('games.Derrota_Victoria', '=', 1)->join('users', 'games.user_id', '=', 'users.id')->orderby('Porcentaje_total', 'desc')->groupby('users.name')->limit(1)->get();

            return $totalRate;
        }
    }

}
