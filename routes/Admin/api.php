<?php

use Illuminate\Support\Facades\Route;

$idRegex = '[0-9]+';
$slugRegex = '[0-9a-z\-]+';

/* Route::group(['middleware' => 'auth:sanctum'], function () {}); */

// Users
Route::apiResource(name : 'user', controller : App\Http\Controllers\API\UserController::class)
    ->except(methods : ['store']);

Route::get(uri : '/check-user-childrens/{user}', action : [App\Http\Controllers\API\UserController::class, 'checkChildrens'])
    ->name('check-user-childrens')
    ->where(['user' => $idRegex]);

Route::delete(uri : '/destroy-users', action : [App\Http\Controllers\API\UserController::class, 'destroyUsers'])
    ->name('destroy-users');


// Subscriptions
Route::apiResource(name : 'subscription', controller : App\Http\Controllers\API\SubscriptionController::class);

Route::delete(uri : '/destroy-subscriptions', action : [App\Http\Controllers\API\SectorController::class, 'destroySubscriptions'])
    ->name('destroy-subscriptions');


// Permissions
Route::apiResource(name : 'permission', controller : App\Http\Controllers\API\PermissionController::class)
    ->except(['store', 'update', 'destroy']);


// Rôles
Route::apiResource(name : 'role', controller : App\Http\Controllers\API\RoleController::class);

Route::get(uri : '/check-role-childrens/{role}', action : [App\Http\Controllers\API\RoleController::class, 'checkChildrens'])
    ->name('check-role-childrens')
    ->where(['role' => $idRegex]);

Route::delete(uri : '/destroy-roles', action : [App\Http\Controllers\API\SectorController::class, 'destroyRoles'])
    ->name('destroy-roles');


// Cycles
Route::apiResource(name : 'cycle', controller : App\Http\Controllers\API\CycleController::class);

Route::get(uri : '/check-cycle-childrens/{cycle}', action : [App\Http\Controllers\API\CycleController::class, 'checkChildrens'])
    ->name('check-cycle-childrens')
    ->where(['cycle' => $idRegex]);

Route::delete(uri : '/destroy-cycles', action : [App\Http\Controllers\API\CycleController::class, 'destroyCycles'])
    ->name('destroy-cycles');


// Filières et spécialités

Route::apiResource(name : 'sector', controller : App\Http\Controllers\API\SectorController::class);

Route::get(uri : '/check-sector-childrens/{sector}', action : [App\Http\Controllers\API\SectorController::class, 'checkChildrens'])
    ->name('check-sector-childrens')
    ->where(['sector' => $idRegex]);

Route::delete(uri : '/destroy-sectors', action : [App\Http\Controllers\API\SectorController::class, 'destroySectors'])
    ->name('destroy-sectors');
