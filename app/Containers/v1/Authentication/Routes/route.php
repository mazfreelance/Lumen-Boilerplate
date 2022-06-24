<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->post('login', ['uses' => 'Controller@login', 'as' => 'login']);
$router->post('register', ['uses' => 'Controller@register', 'as' => 'register']);
$router->post('email-verification', ['uses' => 'Controller@emailVerification', 'as' => 'emailVerification']);
$router->post('forgot-password', ['uses' => 'Controller@forgotPassword', 'as' => 'forgotPassword']);
$router->post('reset-password', ['uses' => 'Controller@resetPassword', 'as' => 'resetPassword']);
$router->post('refresh-token', ['uses' => 'Controller@refreshToken', 'as' => 'refreshToken']);

$router->group(['middleware' => 'auth'], function () use ($router) {
    $router->post('logout', ['uses' => 'Controller@logout', 'as' => 'logout']);
    $router->post('resend-email-verification', ['uses' => 'Controller@resendEmailVerification', 'as' => 'resendEmailVerification']);
});
