<?php

namespace App\Http\Resources\Soutenance;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SoutenanceCollection extends ResourceCollection
{

    public $collects = SoutenanceResource::class;

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
