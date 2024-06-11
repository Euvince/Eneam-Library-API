<?php

namespace App\Http\Resources\Role;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @role Role $resource
 */
class RoleResource extends JsonResource
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
            'created_at' => $this->resource->created_at->format("Y-m-d"),
            'updated_at' => $this->resource->updated_at->format("Y-m-d"),
            'created_by' => $this->resource->created_by,
            'updated_by' => $this->resource->updated_by,
            'permissions' => $this->when(
                $this->relationLoaded('permissions') && $this->resource->permissions->count() > 0,
                $this->resource->permissions
            ),
            'users' => $this->when(
                $this->relationLoaded('users') && $this->resource->users->count() > 0,
                $this->resource->users
            ),
        ];
    }
}
