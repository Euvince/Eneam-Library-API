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
            /* 'type' => $this->resource->type, */
            'title' => $this->resource->title,
            'slug' => $this->resource->slug,
            'summary' => $this->resource->summary,
            'author' => $this->resource->author,
            'editor' => $this->resource->editor,
            'editing_year' => $this->resource->editing_year,
            'cote' => $this->resource->cote,
            'number_pages' => $this->resource->number_pages,
            'IBSN' => $this->resource->IBSN,
            'available_stock' => $this->resource->available_atock,
            'available' => $this->resource->available,
            'loaned' => $this->resource->loaned,
            /* 'reserved' => $this->resource->reserved, */
            'has_ebooks' => $this->resource->has_ebooks,
            'is_physical' => $this->resource->is_physical,
            'has_audios' => $this->resource->has_audios,
            'likes_number' => $this->resource->likes_number,
            'views_number' => $this->resource->views_number,
            'stars_number' => $this->resource->stars_number,
            /* 'keywords' => json_decode($this->resource->keywords),
            'formats' => json_decode($this->resource->formats), */
            'thumbnail_path' => $this->when($this->resource->thumbnail_path !== NULL, $this->resource->thumbnail_path),
            'file_path' => $this->resource->file_path,
            'files_paths' => $this->when($this->resource->files_paths !== NULL, $this->resource->files_paths),
            'created_at' => $this->resource->created_at->format("Y-m-d"),
            'updated_at' => $this->resource->updated_at->format("Y-m-d"),
            'created_by' => $this->resource->created_by,
            'updated_by' => $this->resource->updated_by,
            'school_year' => $this->whenLoaded('schoolYear'),
            'keywords' => $this->when(
                $this->relationLoaded('keywords') && $this->resource->keywords->count() > 0,
                $this->resource->keywords
            ),
            'comments' => $this->when(
                $this->relationLoaded('comments') && $this->resource->comments->count() > 0,
                $this->resource->comments
            ),
            'loans' => $this->when(
                $this->relationLoaded('loans') && $this->resource->loans->count() > 0,
                $this->resource->loans
            ),
        ];
    }
}
