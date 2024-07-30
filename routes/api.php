<?php

use App\Http\Controllers\API\Statistiques\StatistiquesController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Resources\User\UserResource;
use App\Http\Responses\User\SingleUserResponse;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

$idRegex = '[0-9]+';
$slugRegex = '[0-9a-z\-]+';

Route::middleware('auth:sanctum')->get('/auth-user', function (Request $request) {
    return $request->user()->load(['roles'/* , 'permissions' */]);
});


Route::middleware([/* 'auth:sanctum', 'verified', 'role:Administrateur, Gestionnaire' */])->get('/statistiques', function (Request $request) {
    Route::get(uri : 'statistiques', action : [StatistiquesController::class]);
});
