<?php

use Illuminate\Support\Facades\Route;

Route::group(/* ['middleware' => 'auth:sanctum'],  */function () {
    Route::apiResource(name : 'cycles', controller : App\Http\Controllers\API\CycleController::class);
});
