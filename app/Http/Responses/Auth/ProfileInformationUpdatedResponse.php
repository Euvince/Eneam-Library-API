<?php

namespace App\Http\Responses\Auth;

use Laravel\Fortify\Contracts\ProfileInformationUpdatedResponse as ContractsProfileInformationUpdatedResponse;

class ProfileInformationUpdatedResponse implements ContractsProfileInformationUpdatedResponse
{
    public function toResponse($request) {
        return response()->json(data : [
            "message" => "Informations de profile modifiées avec succès",
        ], status : 200);
    }
}
