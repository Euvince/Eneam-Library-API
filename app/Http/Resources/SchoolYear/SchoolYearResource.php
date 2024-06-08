<?php

namespace App\Http\Resources\SchoolYear;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @configuration SchoolYear $resource
 */

class SchoolYearResource extends JsonResource
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
            'start_date' => $this->resource->start_date,
            'end_date' => $this->resource->end_date,
            'school_year' => $this->resource->school_year,
            'created_at' => $this->resource->created_at->format("Y-m-d"),
            'updated_at' => $this->resource->updated_at->format("Y-m-d"),
            'created_by' => $this->resource->created_by,
            'updated_by' => $this->resource->updated_by,
            'configurations' => $this->when(
                $this->relationLoaded('configurations') && $this->resource->configurations->count() > 0,
                $this->resource->configurations
            ),
            'soutenances' => $this->when(
                $this->relationLoaded('soutenances') && $this->resource->soutenances->count() > 0,
                $this->resource->soutenances
            ),
            'articles' => $this->when(
                $this->relationLoaded('articles') && $this->resource->articles->count() > 0,
                $this->resource->articles
            ),
        ];
    }
}
