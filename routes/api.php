<?php

use App\Http\Controllers\Api\AppointmentController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DoctorController;
use App\Http\Controllers\Api\HealthPlanController;
use App\Http\Controllers\Api\PacientController;
use App\Http\Controllers\Api\ProcedureController;
use App\Http\Controllers\Api\SpecialtyController;
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

Route::apiResources([
    'procedures' => ProcedureController::class,
    'doctors' => DoctorController::class,
    'health-plans' => HealthPlanController::class,
    'pacients' => PacientController::class,
    'specialties' => SpecialtyController::class,
    'procedures' => ProcedureController::class,
    'appointments' => AppointmentController::class,
]);
