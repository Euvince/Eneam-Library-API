<?php

namespace App\Http\Responses\Auth;

use App\Contracts\BaseResponse;

class HasVerifiedEmailResponse implements BaseResponse
{
     /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request) {
        if ($request->wantsJson()) {
            return response()->json(data : [
                "message" => "Vous avez déjà vérifié votre addresse email.",
            ], status : 200);
        }
    }
}
