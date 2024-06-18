<?php

use Illuminate\Support\Facades\Route;

$verificationLimiter = config('fortify.limiters.verification', '6,1');

// Personnalisations de quelques points d'authentification

Route::post(uri : 'email/verification-notification', action : [App\Http\Controllers\API\Auth\EmailVerificationNotificationController::class, 'store'])
    ->middleware([
        'auth:sanctum',
        'throttle:'.$verificationLimiter
    ]);

Route::middleware('auth:sanctum')->post(uri : 'update-profile-picture', action : [App\Http\Controllers\API\Auth\ProfilePictureController::class, 'update']);
Route::middleware('auth:sanctum')->post(uri : 'remove-profile-picture', action : [App\Http\Controllers\API\Auth\ProfilePictureController::class, 'delete']);
/* Route::middleware('auth:sanctum')->post(uri : 'logout', action : [App\Http\Controllers\API\Auth\LogoutController::class, 'logout']); */
