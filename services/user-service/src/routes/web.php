<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/
$router->get('/_health', function (){
    return response()->json(['service' => 'user-service', 'status' => 'OK'], 200);
});
$router->group(['prefix' => '/auth'], function ($router){
    $router->post('/login', 'AuthController@login');
    $router->get('/me', 'AuthController@me');
    $router->post('/register', 'AuthController@register');
});
