<?php

namespace App\Responses\SupportedMemory;

use App\Http\Resources\SupportedMemory\SupportedMemoryResource;
use Illuminate\Contracts\Support\Responsable;

class SingleSupportedMemoryResponse implements Responsable
{
    public function __construct(
        private readonly string $allowValue,
        private readonly string|null $message,
        private readonly int $statusCode = 200,
        private readonly SupportedMemoryResource|array $resource,
    )
    {
    }

    public function toResponse($request) {
        $response = response()->json(
            status : $this->statusCode,
            headers : [
                'Allow' => $this->allowValue,
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
