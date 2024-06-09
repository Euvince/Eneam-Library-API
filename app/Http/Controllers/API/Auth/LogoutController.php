<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Responses\Auth\LogoutResponse;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\Request;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;

class LogoutController extends AuthenticatedSessionController
{
    public function logout (AuthManager $auth, Request $request) : LogoutResponse {
        $request->user()->currentAccessToken()->delete();
        return app(LogoutResponse::class);
    }
}
