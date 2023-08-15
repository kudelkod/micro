<?php

use App\Http\Controllers\Book\BookApiController;
use App\Http\Controllers\User\UserApiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['prefix' => '/user'], function ($route){
    $route->get('/', [UserApiController::class, 'index']);
});
Route::group(['prefix' => '/book'], function ($route){
    $route->get('/', [BookApiController::class, 'index']);
});

