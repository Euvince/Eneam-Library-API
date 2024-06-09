<?php

namespace App\Http\Responses\Auth;

use App\Models\User;
use Laravel\Fortify\Contracts\LoginResponse as ContractsLoginResponse;

class LoginResponse implements ContractsLoginResponse
{
    public function toResponse($request) {
        if ($request->wantsJson()) {
            $user = User::where('email', $request->email)->first();
            return response()->json(data : [
                "message" => "Utilisateur authentifié avec succès",
                "user" => $user,
                "token" => $user->createToken($request->email)->plainTextToken
            ], status : 200);
        }
    }
}
