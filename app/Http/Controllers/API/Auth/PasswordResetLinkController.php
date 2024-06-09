<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Responses\Auth\PasswordResetResponse;
use Illuminate\Http\Request;
use Laravel\Fortify\Http\Controllers\PasswordResetLinkController as ControllersPasswordResetLinkController;

class PasswordResetLinkController extends ControllersPasswordResetLinkController
{
    public function store (Request $request) : PasswordResetResponse {
        // Code.....
        return app(PasswordResetResponse::class);
    }
}
