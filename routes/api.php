<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

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

Route::group(['prefix' => 'auth'], function ($router) {
    $router->post('login', AuthController::class . '@login');
    $router->post('signup', AuthController::class . '@signup');
    $router->post('logout', AuthController::class . '@logout');
    $router->post('refresh', AuthController::class . '@refresh');
});
