<?php

namespace App\Http\Resources\Article;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @article Article $resource
 */

class ArticleResource extends JsonResource
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
            'type' => $this->resource->type,
            'title' => $this->resource->title,
            'slug' => $this->resource->slug,
            'summary' => $this->resource->summary,
            'author' => $this->resource->author,
            'editor' => $this->resource->editor,
            'editing_year' => $this->resource->editing_year,
            'cote' => $this->resource->cote,
            'number_pages' => $this->resource->number_pages,
            'IBSN' => $this->resource->IBSN,
            'available_atock' => $this->resource->available_atock,
            'available' => $this->resource->available,
            'loaned' => $this->resource->loaned,
            'reserved' => $this->resource->reserved,
            'has_ebook' => $this->resource->has_ebook,
            'has_podcast' => $this->resource->has_podcast,
            'likes_number' => $this->resource->likes_number,
            'views_number' => $this->resource->views_number,
            'stars_number' => $this->resource->stars_number,
            'keywords' => json_decode($this->resource->keywords),
            'formats' => json_decode($this->resource->formats),
            'access_paths' => json_decode($this->resource->access_paths),
            'created_at' => $this->resource->created_at->format("Y-m-d"),
            'updated_at' => $this->resource->updated_at->format("Y-m-d"),
            'created_by' => $this->resource->created_by,
            'updated_by' => $this->resource->updated_by,
            'comments' => $this->when(
                $this->resource->comments->count() > 0,
                $this->whenLoaded('comments')
            ),
            'loans' => $this->when(
                $this->resource->loans->count() > 0,
                $this->whenLoaded('loans')
            ),
        ];
    }
}
