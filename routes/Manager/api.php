<?php

use Illuminate\Support\Facades\Route;


Route::apiResource(name : 'soutenance', controller : App\Http\Controllers\API\SoutenanceController::class);
Route::apiResource(name : 'memory', controller : App\Http\Controllers\API\SupportedMemory\SupportedMemoryController::class);
