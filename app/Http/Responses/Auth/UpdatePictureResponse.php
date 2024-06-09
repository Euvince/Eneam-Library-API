<?php

namespace App\Http\Responses\Auth;

use App\Contracts\BaseResponse;

class UpdatePictureResponse implements BaseResponse
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
                "message" => "Photo de profile modifiée avec succès.",
            ], status : 200);
        }
    }
}
