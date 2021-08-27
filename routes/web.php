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
    // dd(phpinfo());
    return $router->app->version();
});
$router->group(['prefix' => 'api'],function() use ($router){
    $router->get('/debug-sentry', function () {
        throw new Exception('My first Sentry error!');
    });;
    $router->get('/task-3', 'TaskController@task3');
    $router->get('/task-6-success', 'TaskController@task6Success');
    $router->get('/task-6-fail', 'TaskController@task6Fail');
    $router->get('/task-7', 'TaskController@task7');
    $router->get('/task-8', 'TaskController@task8');
    $router->get('/task-10', 'TaskController@task10');
    $router->post('/register', 'AuthController@register');
    $router->post('/login', 'AuthController@login');
    $router->get('/check-login', 'AuthController@checkLogin');
    $router->get('/post', 'PostController@index');
    $router->get('/post/{id}', 'PostController@show');
    $router->get('/firebase', 'FirebaseProjectController@index');
    $router->get('/firebase/{id}', 'FirebaseProjectController@show');
    $router->group(['middleware' => ['auth:api']],function() use ($router){
        $router->get('/me', 'AuthController@me');
        $router->get('/logout', 'AuthController@logout');
        $router->get('/users', 'UserController@index');
        $router->post('/users', 'UserController@store');
        $router->post('/post', 'PostController@store');
        $router->put('/post', 'PostController@update');
        $router->delete('/post/{id}', 'PostController@destroy');
        $router->post('/firebase', 'FirebaseProjectController@store');
        $router->put('/firebase', 'FirebaseProjectController@update');
        $router->delete('/firebase', 'FirebaseProjectController@destroy');
    });
});
