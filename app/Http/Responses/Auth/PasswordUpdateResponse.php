<?php

namespace App\Http\Responses\Auth;

use Laravel\Fortify\Contracts\PasswordUpdateResponse as ContractsPasswordUpdateResponse;

class PasswordUpdateResponse implements ContractsPasswordUpdateResponse
{
    public function toResponse($request) {
        return response()->json(data : [
            "message" => "Votre mot de passe a été mofifié avec succès",
        ], status : 200);
    }
}
