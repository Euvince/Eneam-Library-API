<?php

namespace App\Http\Responses\Role;

use App\Http\Resources\Role\RoleResource;
use Illuminate\Contracts\Support\Responsable;

class SingleRoleResponse implements Responsable
{
    public function __construct(
        private readonly string $allowedMethods,
        private readonly string|null $message,
        private readonly int $statusCode = 200,
        private readonly RoleResource|array $resource,
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
