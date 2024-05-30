<?php

namespace App\Responses\Sector;

use App\Http\Resources\Sector\SectorCollection;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class SectorCollectionResponse implements Responsable
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
            data : SectorCollection::make(resource : $this->collection)->response()->getData()
        );
        return $response->header(key : 'Content-Length', values : strlen($response->content()));
    }
}
