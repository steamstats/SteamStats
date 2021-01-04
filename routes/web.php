<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GamesController;
use App\Http\Controllers\ReplyController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\StatController;
use Illuminate\Support\Facades\Route;
use Symfony\Component\Console\Input\Input;
use App\Models\Game;
use Illuminate\View\Middleware\ShareErrorsFromSession;

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

Route::get('/', [StatController::class, 'index']);

Route::get('/auth/steam', [AuthController::class, 'redirectToSteam']);

Route::get('/auth/steam/handle', [AuthController::class, 'handle']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/user/{id}', [ProfileController::class, 'index']);

Route::get('/searchuser', [ProfileController::class, 'test']);

Route::get('/user/', [ProfileController::class, 'show']);

Route::get('/get_games', [GamesController::class, 'store']);

Route::get('/games', [GamesController::class, 'index']);

Route::get('/sort_genre', [GamesController::class, 'sortGenre']);

Route::get('/sort_categories', [GamesController::class, 'sortCategories']);

Route::get('/search', [GamesController::class, 'search']);

Route::get('/game/{id}', [GamesController::class, 'show'])->name('game');

Route::post('/createreview', [ReviewController::class, 'store'])->name('createreview');

Route::post('/createreply', [ReplyController::class, 'storeReply'])->name('createreply');

Route::get('/editReview/{id}', [ReviewController::class, 'show'])->name('editreview');

Route::post('/updateReview', [ReviewController::class, 'update'])->name('updatereview');

Route::get('/deleteReview/{id}', [ReviewController::class, 'delete'])->name('deletereview');

Route::post('/destroyReview', [ReviewController::class, 'destroy'])->name('destroyreview');

Route::get('/editReply/{id}', [ReplyController::class, 'show'])->name('editreply');

Route::post('/updateReply', [ReplyController::class, 'update'])->name('updatereply');

Route::get('/deleteReply/{id}', [ReplyController::class, 'delete'])->name('deletereply');

Route::post('/destroyReply', [ReplyController::class, 'destroy'])->name('destroyreply');
