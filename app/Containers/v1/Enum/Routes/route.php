<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->get('/queue-type', ['uses' => 'Controller@queueType', 'as' => 'queueType']);
$router->get('/system-locale', ['uses' => 'Controller@systemLocale', 'as' => 'systemLocale']);
$router->get('/user-online-status', ['uses' => 'Controller@userOnlineStatus', 'as' => 'userOnlineStatus']);
$router->get('/user-status', ['uses' => 'Controller@userStatus', 'as' => 'userStatus']);
$router->get('/user-verify-status', ['uses' => 'Controller@userVerifyStatus', 'as' => 'userVerifyStatus']);
