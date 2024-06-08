<?php

namespace App\Http\Responses\SchoolYear;

use App\Http\Resources\SchoolYear\SchoolYearResource;
use Illuminate\Contracts\Support\Responsable;

class SingleSchoolYearResponse implements Responsable
{
    public function __construct(
        private readonly string $allowedMethods,
        private readonly string|null $message,
        private readonly int $statusCode = 200,
        private readonly SchoolYearResource|array $resource,
    )
    {
    }

    public function toResponse($request) {
        $response = response()->json(
            status : $this->statusCode,
            headers : [
                'Allow' => $this->allowedMethods,
                'Content-Type' => 'application/json',
            ],
            data :  [
                'message' => $this->message,
                "data" => $this->resource
            ]
        );
        return $response->header(key : 'Content-Length', values : mb_strlen($response->content()));
    }
}
