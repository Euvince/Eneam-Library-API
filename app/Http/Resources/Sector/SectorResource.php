<?php

namespace App\Http\Resources\Sector;

use App\Models\Sector;
use Illuminate\Http\Request;
use App\Http\Resources\Sector\SectorCollection;
use App\Http\Resources\SupportedMemory\SupportedMemoryCollection;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @sector Sector $resource
 */
class SectorResource extends JsonResource
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
            'acronym' => $this->resource->acronym,
            'type' => $this->resource->type,
            'created_at' => $this->resource->created_at->format("Y-m-d"),
            'updated_at' => $this->resource->updated_at->format("Y-m-d"),
            'created_by' => $this->resource->created_by,
            'updated_by' => $this->resource->updated_by,

            'sector' => $this->when(
                strtolower($this->resource->type) === strtolower("Spécialité") && $this->resource->sector_id !== NULL,
                new $this($this->whenLoaded('sector'))
            ),
            'specialities' => $this->when(
                strtolower($this->resource->type) === strtolower("Filière") && $this->resource->specialities->count() > 0,
                SectorCollection::make($this->whenLoaded('specialities'))
            ),
            /* $this->mergeWhen($this->resource->specialities != [], $this->resource->type === "Filière",  [
                'specialities' => SectorCollection::make($this->whenLoaded('specialities'))
            ]), */
            'supportedMemories' => $this->when(
                $this->resource->supportedMemories->count() > 0,
                SupportedMemoryCollection::make($this->whenLoaded('supportedMemories'))
            ),
        ];
    }
}
