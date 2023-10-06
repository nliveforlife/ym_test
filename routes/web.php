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
    return $router->app->version();
});

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->post('user/register', ['uses' => 'ApiController@userRegister']);
    $router->post('user/sign-in', ['uses' => 'ApiController@userAuth']);
    $router->get('user/companies', ['uses' => 'ApiController@userFindCompanies']);
    $router->post('user/companies', ['uses' => 'ApiController@userAddCompany']);
    $router->post('user/recover-password', ['uses' => 'ApiController@userRecoverPassword']);
    $router->patch('user/recover-password', ['uses' => 'ApiController@userRecoverPassword']);
});
