<?php

namespace App\Http\Resources\Sector;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SectorCollection extends ResourceCollection
{

    public $collects = SectorResource::class;

    public function __construct(
        public $resource,
    )
    {
        parent::__construct($this->resource);
    }

    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => $this->collection,
        ];
    }
}
