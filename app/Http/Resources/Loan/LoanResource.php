<?php

namespace App\Http\Resources\Loan;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @loan Loan $resource
 */
class LoanResource extends JsonResource
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
            'status' => $this->resource->status,
            'duration' => $this->resource->duration,
            'renewals' => $this->resource->renewals,
            'loan_date' => $this->resource->loan_date,
            'processing_date' => $this->resource->processing_date,
            'created_at' => $this->resource->created_at->format("Y-m-d"),
            'updated_at' => $this->resource->updated_at->format("Y-m-d"),
            'created_by' => $this->resource->created_by,
            'updated_by' => $this->resource->updated_by,
            /* 'articles' => $this->when(
                $this->relationLoaded('articles'),
                $this->resource->articles
            ), */
            'article' => $this->when(
                $this->relationLoaded('article'),
                $this->resource->article
            ),
            'user' => $this->when(
                $this->relationLoaded('user'),
                $this->resource->user
            ),
        ];
    }
}
