<?php

namespace App\Http\Resources\SupportedMemory;

use App\Http\Resources\Sector\SectorResource;
use App\Http\Resources\Soutenance\SoutenanceResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @supportedMemory SupportedMemory $resource
 */
class SupportedMemoryResource extends JsonResource
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
            'theme' => $this->resource->theme,
            'start_at' => $this->resource->start_at,
            'ends_at' => $this->resource->ends_at,
            'ends_at' => $this->resource->ends_at,
            'first_author_name' => $this->resource->first_author_name,
            'second_author_name' => $this->resource->second_author_name,
            'first_author_email' => $this->resource->first_author_email,
            'second_author_email' => $this->resource->second_author_email,
            'first_author_phone' => $this->resource->first_author_phone,
            'second_author_phone' => $this->resource->second_author_phone,
            'jury_president' => $this->resource->jury_president,
            'memory_master' => $this->resource->memory_master,
            'cote' => $this->resource->cote,
            'status' => $this->resource->status,
            'file_path' => $this->resource->file_path,
            'cover_page_path' => $this->resource->cover_page_path,
            'created_at' => $this->resource->created_at->format("Y-m-d"),
            'updated_at' => $this->resource->updated_at->format("Y-m-d"),
            'created_by' => $this->resource->created_by,
            'updated_by' => $this->resource->updated_by,
            'sector' => $this->whenLoaded('sector'),
            'soutenance' => $this->whenLoaded('soutenance'),
            /* 'sector' => new SectorResource($this->whenLoaded('sector')), */
            /* 'soutenance' => new SoutenanceResource($this->whenLoaded('soutenance')), */
        ];
    }
}
