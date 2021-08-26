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

$router->get('/', function () use ($router) {
    dd(phpinfo());
    return $router->app->version();
});
$router->group(['prefix' => 'api'],function() use ($router){
    $router->post('/register', 'AuthController@register');
    $router->post('/login', 'AuthController@login');
    $router->get('/check-login', 'AuthController@checkLogin');
    $router->get('/post', 'PostController@index');
    $router->get('/post/{id}', 'PostController@show');
    $router->group(['middleware' => ['auth:api']],function() use ($router){
        $router->get('/me', 'AuthController@me');
        $router->get('/logout', 'AuthController@logout');
        $router->get('/users', 'UserController@index');
        $router->post('/users', 'UserController@store');
        $router->post('/post', 'PostController@store');
        $router->put('/post', 'PostController@update');
    });
});
