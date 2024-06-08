<?php

use Illuminate\Support\Facades\Route;

$idRegex = '[0-9]+';
$slugRegex = '[0-9a-z\-]+';

/* Route::group(['middleware' => 'auth:sanctum'], function () {}); */

Route::apiResource(name : 'user', controller : App\Http\Controllers\API\UserController::class);
Route::apiResource(name : 'subscription', controller : App\Http\Controllers\API\SubscriptionController::class);
Route::apiResource(name : 'role', controller : App\Http\Controllers\API\RoleController::class);

Route::apiResource(name : 'cycle', controller : App\Http\Controllers\API\CycleController::class);
Route::apiResource(name : 'sector', controller : App\Http\Controllers\API\SectorController::class);
