<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Middleware\EnsureTokenIsValid;
use App\Http\Middleware;

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

Route::post('/players', [RegisterController::class, 'register'])->name('register');
Route::post('/login', [LoginController::class, 'login'])->name('login');

Route::middleware(['auth:api'])->group(function () {
    
Route::post('logout', [LoginController::class, 'logout']);
Route::get('/all', [UserController::class, 'all'])->name('all');
Route::put('/players/{id}', [UserController::class, 'update'])->name('update');//user

Route::post('/players/{id}/games', [GameController::class, 'store'])->name('store');//user
Route::delete('/players/{id}/games', [GameController::class, 'delete'])->name('delete');//user
Route::get('/players/{id}/games', [GameController::class, 'show'])->name('show');

Route::get('/players', [GameController::class, 'successRate'])->name('successRate');//user
Route::get('/players/ranking', [GameController::class, 'ranking'])->name('ranking');
Route::get('/players/ranking/loser', [GameController::class, 'rankingLoser'])->name('rankingLoser');
Route::get('/players/ranking/winner', [GameController::class, 'rankingWinner'])->name('rankingWinner');
});