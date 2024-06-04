<?php

namespace App\Http\Responses\Cycle;

use App\Http\Resources\Cycle\CycleResource;
use Illuminate\Contracts\Support\Responsable;

class SingleCycleResponse implements Responsable
{
    public function __construct(
        private readonly string $allowedMethods,
        private readonly string|null $message,
        private readonly int $statusCode = 200,
        private readonly CycleResource|array $resource,
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
        return $response->header(key : 'Content-Length', values : strlen($response->content()));
    }
}
