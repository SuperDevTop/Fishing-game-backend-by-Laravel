<?php

use App\Http\Controllers\DataController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/signup', [UserController::class, 'signup']); // the new user signs up
Route::post('/login', [UserController::class, 'login']); // log in
Route::post('/getUserData', [DataController::class, 'getUserData']); // get the data
Route::post('/catch', [DataController::class, 'catch']);  // catch a new fish
Route::post('/sell', [DataController::class, 'sell']);  // sell fishes
