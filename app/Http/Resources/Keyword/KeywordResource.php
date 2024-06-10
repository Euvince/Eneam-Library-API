<?php

namespace App\Http\Resources\Keyword;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @keyword Keyword $resource
 */
class KeywordResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'keyword' => $this->resource->keyword,
            'likes_number' => $this->resource->likes_number,
            'created_at' => $this->resource->created_at->format("Y-m-d"),
            'updated_at' => $this->resource->updated_at->format("Y-m-d"),
            'created_by' => $this->resource->created_by,
            'updated_by' => $this->resource->updated_by,
        ];
    }
}
