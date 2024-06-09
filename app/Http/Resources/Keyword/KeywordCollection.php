<?php

namespace App\Http\Resources\Keyword;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class KeywordCollection extends ResourceCollection
{

    public $collects = KeywordResource::class;

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
