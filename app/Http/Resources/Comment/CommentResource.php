<?php

namespace App\Http\Resources\Comment;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


/**
 * @sector Commment $resource
 */
class CommentResource extends JsonResource
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
            'content' => $this->resource->content,
            'likes_number' => $this->resource->likes_number,
            'created_at' => $this->resource->created_at->format("Y-m-d"),
            'updated_at' => $this->resource->updated_at->format("Y-m-d"),
            'created_by' => $this->resource->created_by,
            'updated_by' => $this->resource->updated_by,
            'article' => $this->when(
                $this->relationLoaded('specialities') && mb_strtolower($this->resource->type) === mb_strtolower("Spécialité") && $this->resource->sector_id !== NULL,
                $this->resource->specialities
            ),
        ];
    }
}
