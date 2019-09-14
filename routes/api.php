<?php

use Illuminate\Http\Request;
use Illuminate\Routing\Router;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['namespace' => 'Api'], function (Router $router){
    $router->post('/order', 'OrderController@store');

    $router->post('/order/{id}/upgradeStatus', 'OrderController@upgradeStatus')
        ->where('id', '[0-9]+');

    $router->post('/order/{id}/lowerStatus', 'OrderController@lowerStatus')
        ->where('id', '[0-9]+');
});
