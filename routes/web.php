<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GamesController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/auth/steam', [AuthController::class, 'redirectToSteam']);

Route::get('/auth/steam/handle', [AuthController::class, 'handle']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/profile', [ProfileController::class, 'index']);


Route::get('/get_games', [GamesController::class, 'store']);

Route::get('/games', [GamesController::class, 'index']);

Route::get('/game/{id}', [GamesController::class, 'show'])->name('game');
