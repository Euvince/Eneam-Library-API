<?php

namespace App\Http\Responses\Auth;

use Laravel\Fortify\Contracts\ProfileInformationUpdatedResponse as ContractsProfileInformationUpdatedResponse;

class ProfileInformationUpdatedResponse implements ContractsProfileInformationUpdatedResponse
{
    public function toResponse($request) {
        return response()->json(data : [
            "message" => "Vos informations de profile ont été modifiées avec succès",
        ], status : 200);
    }
}
