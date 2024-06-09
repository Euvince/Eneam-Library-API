<?php

namespace App\Http\Controllers\API\Auth;

use Illuminate\Http\Request;
use App\Http\Responses\Auth\SendEmailResponse;
use App\Jobs\AskAgainEmailVerificationLinkJob;
use App\Http\Responses\Auth\HasVerifiedEmailResponse;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Fortify\Http\Controllers\EmailVerificationNotificationController as ControllersEmailVerificationNotificationController;

class EmailVerificationNotificationController extends ControllersEmailVerificationNotificationController
{
    public function store (Request $request) : HasVerifiedEmailResponse | SendEmailResponse {
        $user = $request->user();
        if ($user instanceof MustVerifyEmail)
        {
            if ($user->hasVerifiedEmail()) {
                return app(HasVerifiedEmailResponse::class);
            }
            AskAgainEmailVerificationLinkJob::dispatch($user);
            return app(SendEmailResponse::class);
        }
    }
}
