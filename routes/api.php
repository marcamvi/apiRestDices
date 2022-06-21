<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GameController;

/*
  |--------------------------------------------------------------------------
  | API Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register API routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | is assigned the "api" middleware group. Enjoy building your API!
  |
 */

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//  return $request->user();
//});


Route::post('/players', 'App\Http\Controllers\RegisterController@register');
Route::post('/login', 'App\Http\Controllers\LoginController@login');
Route::middleware('auth:api')->get('/all', 'App\Http\Controllers\UserController@all');

Route::put('/players/{id}', [UserController::class, 'update'])->middleware('auth:api');

Route::post('/players/{id}/games', [GameController::class, 'store'])->middleware('auth:api');
Route::delete('/players/{id}/games', [GameController::class, 'delete'])->middleware('auth:api');
Route::get('/players/{id}/games', [GameController::class, 'show'])->middleware('auth:api');

Route::get('/players', [GameController::class, 'successRate'])->middleware('auth:api');
Route::get('/players/ranking', [GameController::class, 'ranking'])->middleware('auth:api');
Route::get('/players/ranking/loser', [GameController::class, 'rankingLoser'])->middleware('auth:api');
Route::get('/players/ranking/winner', [GameController::class, 'rankingWinner'])->middleware('auth:api');