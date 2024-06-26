<?php

namespace App\Http\Resources\Cycle;

use App\Http\Resources\Soutenance\SoutenanceCollection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @cycle Cycle $resource
 */
class CycleResource extends JsonResource
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
            'name' => $this->resource->name,
            'slug' => $this->resource->slug,
            'code' => $this->resource->code,
            'created_at' => $this->resource->created_at->format("Y-m-d"),
            'updated_at' => $this->resource->updated_at->format("Y-m-d"),
            'created_by' => $this->resource->created_by,
            'updated_by' => $this->resource->updated_by,
            'soutenances' => $this->when(
                $this->relationLoaded('soutenances') && $this->resource->soutenances->count() > 0,
                $this->resource->soutenances
            ),
            /* 'soutenances' => $this->when(
                $this->resource->soutenances->count() > 0,
                SoutenanceCollection::make($this->whenLoaded('soutenances'))
            ), */
        ];
    }
}
