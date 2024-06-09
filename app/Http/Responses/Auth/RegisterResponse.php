<?php

namespace App\Http\Responses\Auth;

use App\Models\User;
use Laravel\Fortify\Contracts\RegisterResponse as ContractsRegisterResponse;

class RegisterResponse implements ContractsRegisterResponse
{
    public function toResponse($request) {
        if ($request->wantsJson()) {
            $user = User::where('email', $request->email)->first();
            return response()->json(data : [
                "message" => "Compte crée avec succès, vérifiez votre adresse email.",
                "user" => $user,
                "token" => $user->createToken($request->email)->plainTextToken
            ], status : 201);
        }
    }
}
