<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\SoutenanceController;
use App\Http\Controllers\API\SupportedMemory\SupportedMemoryController;

$idRegex = '[0-9]+';
$slugRegex = '[0-9a-z\-]+';

Route::apiResource(name : 'soutenance', controller : SoutenanceController::class);
Route::apiResource(name : 'supportedMemory', controller : SupportedMemoryController::class)->except(methods : ['store', 'update']);
