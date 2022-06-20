<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use App\Models\Game;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class GameController extends Controller {

    public function store($id) {

        $dice1 = rand(1, 6);
        $dice2 = rand(1, 6);
        $throw = new Game;
        $throw->Tirada_Uno = $dice1;
        $throw->Tirada_Dos = $dice2;
        $throw->users_id = $id;

        if (($dice1 + $dice2) >= 7) {
            $throw->Derrota_Victoria = 1; //Victoria
        } else {
            $throw->Derrota_Victoria = 0; //Derrota
        }
        $throw->save();
        return $throw;
    }

    public function delete($id, Game $game) {
        $deleted = Game::where('users_id', $id)->delete();
    }

    public function show($id, Game $game) {
        return Game::where('users_id', $id)->get();
    }

    public function succesRate(Game $game) {

        $rate = DB::table('games')
                ->selectraw('users.name as Nombre, COUNT(games.Derrota_Victoria) as Total_partidas, ROUND(100*SUM(games.Derrota_Victoria=1)/COUNT(games.Derrota_Victoria)) as Porcentaje_Victorias, ROUND(100*SUM(games.Derrota_Victoria=0)/COUNT(games.Derrota_Victoria))as Porcentaje_Derrotas')->join('users', 'games.users_id', '=', 'users.id')->groupby('users.name')->get();

        return $rate;
    }
    public function ranking(Game $game) {
       

    $totalRate = DB::table('games') ->selectraw('users.name as Nombre, COUNT(games.users_id) as Total_Victorias, ROUND(100*COUNT(games.Derrota_Victoria)/(SELECT COUNT(games.Derrota_Victoria) FROM games WHERE games.Derrota_Victoria=1)) as Porcentaje_total')->where('games.Derrota_Victoria','=',1)->join('users', 'games.users_id', '=', 'users.id')->orderby('Porcentaje_total', 'desc')->groupby('users.name')->get();
   
        return $totalRate;
    }
        public function rankingLoser(Game $game) {
       

    $totalRate = DB::table('games') ->selectraw('users.name as Nombre, COUNT(games.users_id) as Total_Victorias, ROUND(100*COUNT(games.Derrota_Victoria)/(SELECT COUNT(games.Derrota_Victoria) FROM games WHERE games.Derrota_Victoria=1)) as Porcentaje_total')->where('games.Derrota_Victoria','=',1)->join('users', 'games.users_id', '=', 'users.id')->orderby('Porcentaje_total', 'asc')->groupby('users.name')->limit(1)->get();
   
        return $totalRate;
    }
        public function rankingWinner(Game $game) {
       

    $totalRate = DB::table('games') ->selectraw('users.name as Nombre, COUNT(games.users_id) as Total_Victorias, ROUND(100*COUNT(games.Derrota_Victoria)/(SELECT COUNT(games.Derrota_Victoria) FROM games WHERE games.Derrota_Victoria=1)) as Porcentaje_total')->where('games.Derrota_Victoria','=',1)->join('users', 'games.users_id', '=', 'users.id')->orderby('Porcentaje_total', 'desc')->groupby('users.name')->limit(1)->get();
   
        return $totalRate;
    }

}
