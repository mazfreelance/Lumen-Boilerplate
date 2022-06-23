<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->group(['middleware' => 'auth'], function () use ($router) {
    $router->get('/', 'Controller@index');
    $router->get('/{notificationId}', 'Controller@show');
    $router->put('/{notificationId}/read', 'Controller@read');
    $router->put('/multi-read', 'Controller@multiRead');
    $router->delete('/multi-delete', 'Controller@multiDelete');
});
