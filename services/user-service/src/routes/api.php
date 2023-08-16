<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
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

Route::prefix('/auth')->group(function ($route){
    $route->post('/login', [AuthController::class, 'login']);
    $route->get('/me', [AuthController::class, 'me']);
    $route->post('/register', [AuthController::class, 'register']);
});

