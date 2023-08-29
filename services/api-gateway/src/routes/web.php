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
    return response()->json(['service' => 'api-gateway', 'status' => 'OK'], 200);
});
$router->group(['prefix' => '/auth'], function ($router){
    $router->post('/login', 'AuthController@login');
    $router->post('/register', 'AuthController@register');
    $router->post('/refresh', 'AuthController@refresh');
});

$router->group(['prefix' => '/email'], function ($router){
    $router->get('/verify/{token}', 'EmailController@verify');
});

$router->group(['prefix' => '/user', 'namespace' => 'User', 'middleware' => 'auth'], function ($router){
    $router->get('/me', 'UserController@me');
});
