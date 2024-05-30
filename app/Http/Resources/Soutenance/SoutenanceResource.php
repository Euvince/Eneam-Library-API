<?php

namespace App\Http\Resources\Soutenance;

use Illuminate\Http\Request;
use App\Http\Resources\Cycle\CycleResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\SupportedMemory\SupportedMemoryCollection;

/**
 * @soutenance Soutenance $resource
 */
class SoutenanceResource extends JsonResource
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
            'year' => $this->resource->year,
            'start_date' => $this->resource->start_date,
            'end_date' => $this->resource->end_date,
            'number_memories_expected' => $this->resource->number_memories_expected,
            'created_at' => $this->resource->created_at->format("Y-m-d"),
            'updated_at' => $this->resource->updated_at->format("Y-m-d"),
            'created_by' => $this->resource->created_by,
            'updated_by' => $this->resource->updated_by,
            'cycle' => new CycleResource($this->whenLoaded('cycle')),
            'supportedMemories' => SupportedMemoryCollection::make($this->whenLoaded('supportedMemories')),
        ];
    }
}
