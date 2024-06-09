<?php

$idRegex = '[0-9]+';
$slugRegex = '[0-9a-z\-]+';

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\SupportedMemory\DepositSupportedMemoryController;

$verificationLimiter = config('fortify.limiters.verification', '6,1');

Route::post(uri : 'deposit-memory', action : DepositSupportedMemoryController::class)->name(name : 'deposit-memory');


// Personnalisations de quelques points d'authentification

Route::post(uri : 'update-profile-picture', action : [App\Http\Controllers\API\Auth\ProfilePictureController::class, 'update']);
Route::post(uri : 'remove-profile-picture', action : [App\Http\Controllers\API\Auth\ProfilePictureController::class, 'delete']);

Route::post(uri : 'email/verification-notification', action : [App\Http\Controllers\API\Auth\EmailVerificationNotificationController::class, 'store'])
    ->middleware([
        'auth:sanctum',
        'throttle:'.$verificationLimiter
    ]);

Route::middleware('auth:sanctum')->post(uri : 'logout', action : [App\Http\Controllers\API\Auth\LogoutController::class, 'logout']);
