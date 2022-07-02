<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\LoginController;
use App\Http\Middleware\EnsureTokenIsValid;

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
//, 'user-access: user});
Route::middleware('auth:api')->get('/user', function(Request $request) {
    return $request->user();
});

Route::post('/players', 'App\Http\Controllers\RegisterController@register');
Route::post('/login', 'App\Http\Controllers\LoginController@login');
Route::middleware('auth:api')->get('/all', 'App\Http\Controllers\UserController@all');

Route::middleware(['auth:api'])->group(function () {
    
Route::post('logout', [LoginController::class, 'logout']);

Route::put('/players/{id}', [UserController::class, 'update']);//user

Route::post('/players/{id}/games', [GameController::class, 'store']);//user
Route::delete('/players/{id}/games', [GameController::class, 'delete']);//user
Route::get('/players/{id}/games', [GameController::class, 'show']);

Route::get('/players', [GameController::class, 'successRate']);//user
Route::get('/players/ranking', [GameController::class, 'ranking']);
Route::get('/players/ranking/loser', [GameController::class, 'rankingLoser']);
Route::get('/players/ranking/winner', [GameController::class, 'rankingWinner']);
});