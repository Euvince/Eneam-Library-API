<?php

namespace App\Http\Responses\Auth;

use App\Contracts\BaseResponse;

class SendEmailResponse implements BaseResponse
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
                "message" => "Lien de vérification envoyé, veuillez vérifier votre courrier électronique.",
            ], status : 200);
        }
    }
}
