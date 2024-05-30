<?php

use Illuminate\Support\Facades\Route;

$idRegex = '[0-9]+';
$slugRegex = '[0-9a-z\-]+';

Route::apiResource(name : 'soutenance', controller : App\Http\Controllers\API\SoutenanceController::class);
Route::apiResource(name : 'memory', controller : App\Http\Controllers\API\SupportedMemory\SupportedMemoryController::class);
