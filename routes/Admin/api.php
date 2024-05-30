<?php

use Illuminate\Support\Facades\Route;

/* Route::group(['middleware' => 'auth:sanctum'], function () {}); */

Route::apiResource(name : 'cycle', controller : App\Http\Controllers\API\CycleController::class);
Route::apiResource(name : 'sector', controller : App\Http\Controllers\API\SectorController::class);
