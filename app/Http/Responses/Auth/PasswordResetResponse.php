<?php

namespace App\Http\Responses\Auth;

use Laravel\Fortify\Contracts\PasswordResetResponse as ContractsPasswordResetResponse;

class PasswordResetResponse implements ContractsPasswordResetResponse
{
    public function toResponse($request) {
        return response()->json(data : [
            "message" => "Votre mot de passe a été réinitialisé avec succès",
        ], status : 200);
    }
}
