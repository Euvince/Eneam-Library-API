<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Responses\Auth\LogoutResponse;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;

class LogoutController extends AuthenticatedSessionController
{
    public function logout (AuthManager $auth) : LogoutResponse {
        /* $auth->user()->currentAccessToken()->delete(); */
        $auth->user()->tokens()->delete();
        return app(LogoutResponse::class);
    }
}
