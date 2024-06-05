<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @user User $resource
 */
class UserResource extends JsonResource
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
            'matricule' => $this->resource->matricule,
            'firstname' => $this->resource->firstname,
            'lastname' => $this->resource->lastname,
            'slug' => $this->resource->slug,
            'email' => $this->resource->email,
            'phone_number' => $this->resource->phone_number,
            'birth_date' => $this->resource->birth_date,
            'sex' => $this->resource->sex,
            'profile_photo_path' => $this->resource->piture_profil_path,
            'has_paid' => $this->resource->has_paid,
            'has_access' => $this->resource->has_access,
            'debt_amount' => $this->resource->debt_amount,
            'created_at' => $this->resource->created_at->format("Y-m-d"),
            'updated_at' => $this->resource->updated_at->format("Y-m-d"),
            'created_by' => $this->resource->created_by,
            'updated_by' => $this->resource->updated_by,
            'roles' => $this->when(
                $this->resource->roles->count() > 0,
                $this->whenLoaded('roles')
            ),
            'permissions' => $this->when(
                $this->resource->permissions->count() > 0,
                $this->whenLoaded('permissions')
            ),
        ];
    }
}
