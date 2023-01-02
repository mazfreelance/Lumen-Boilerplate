<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->group(['middleware' => 'auth'], function () use ($router) {
    $router->get('/me', ['uses' => 'ProfileController@me', 'as' => 'me']);

    $router->group(['prefix' => 'profile'], function () use ($router) {
        $router->put('/change-password', ['uses' => 'ProfileController@changePassword', 'as' => 'changePassword']);
    });

    $router->get('/', ['uses' => 'Controller@index', 'as' => 'index']);
    $router->post('/', ['uses' => 'Controller@store', 'as' => 'store']);
    $router->get('/{id}', ['uses' => 'Controller@show', 'as' => 'show']);
    $router->put('/{id}', ['uses' => 'Controller@update', 'as' => 'update']);
    $router->delete('/{id}', ['uses' => 'Controller@destroy', 'as' => 'destroy']);
    $router->post('/export', ['uses' => 'Controller@export', 'as' => 'export']);
});
