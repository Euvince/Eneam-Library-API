<?php

namespace App\Http\Responses\Auth;

use Laravel\Fortify\Contracts\LogoutResponse as ContractsLogoutResponse;

class LogoutResponse implements ContractsLogoutResponse
{
    public function toResponse($request) {
        return response()->json(data : [
            "message" => "Utilisateur déconnecté avec succès",
        ], status : 200);
    }
}
