<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Responses\Auth\LogoutResponse;
use Illuminate\Auth\AuthManager;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;

class LogoutController extends AuthenticatedSessionController
{
    public function logout (AuthManager $auth) : LogoutResponse {
        /* $auth->user()->currentAccessToken()->delete(); */
        $auth->user()->tokens()->delete();
        return app(LogoutResponse::class);
    }
}
