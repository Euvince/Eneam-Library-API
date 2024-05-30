<?php

namespace App\Responses\SupportedMemory;

use App\Http\Resources\SupportedMemory\SupportedMemoryCollection;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class SupportedMemoryCollectionResponse implements Responsable
{
    public function __construct(
        private readonly string $allowValue,
        private readonly int|null $total = 0,
        private readonly int $statusCode = 200,
        private readonly string|null $message = "",
        private readonly Collection|LengthAwarePaginator $collection,
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
            data : SupportedMemoryCollection::make(resource : $this->collection)->response()->getData()
        );
        return $response->header(key : 'Content-Length', values : strlen($response->content()));
    }
}
