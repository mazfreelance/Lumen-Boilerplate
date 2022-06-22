<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->group([], function () use ($router) {
    $router->get('/', ['uses' => 'Controller@index', 'as' => 'index']);
    $router->get('/{id}', ['uses' => 'Controller@show', 'as' => 'show']);
    $router->post('/', ['uses' => 'Controller@store', 'as' => 'store']);
    $router->put('/{id}', ['uses' => 'Controller@update', 'as' => 'update']);
    $router->delete('/{id}', ['uses' => 'Controller@destroy', 'as' => 'delete']);
});
