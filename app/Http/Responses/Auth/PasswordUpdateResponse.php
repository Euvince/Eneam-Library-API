<?php

namespace App\Http\Responses\Auth;

use Laravel\Fortify\Contracts\PasswordUpdateResponse as ContractsPasswordUpdateResponse;

class PasswordUpdateResponse implements ContractsPasswordUpdateResponse
{
    public function toResponse($request) {
        return response()->json(data : [
            "message" => "Mot de passe mofifié avec succès",
        ], status : 200);
    }
}
