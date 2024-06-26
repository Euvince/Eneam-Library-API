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
            'title' => $this->resource->title,
            'slug' => $this->resource->slug,
            'status' => $this->resource->status,
            'duration' => $this->resource->duration,
            'renewals' => $this->resource->renewals,
            'loan_date' => $this->resource->loan_date->format("Y-m-d"),
            'accepted_at' => $this->when(
                condition : !is_null(value :  $this->resource->accepted_at),
                value : $this->resource->accepted_at ? $this->resource->accepted_at->format("Y-m-d") : null
            ),
            'rejected_at' => $this->when(
                condition : !is_null(value :  $this->resource->rejected_at),
                value : $this->resource->rejected_at ? $this->resource->rejected_at->format("Y-m-d") : null
            ),
            'reniew_at' => $this->when(
                condition : !is_null(value :  $this->resource->reniew_at),
                value : $this->resource->reniew_at ? $this->resource->reniew_at->format("Y-m-d") : null
            ),
            'processing_date' => $this->when(
                condition : !is_null(value :  $this->resource->processing_date),
                value : $this->resource->processing_date ? $this->resource->processing_date : null
            ),
            'book_must_returned_on' => $this->when(
                condition : !is_null(value :  $this->resource->book_must_returned_on),
                value : $this->resource->book_must_returned_on ? $this->resource->book_must_returned_on : null
            ),
            'book_recovered_at' => $this->when(
                condition : !is_null(value :  $this->resource->book_recovered_at),
                value : $this->resource->book_recovered_at ? $this->resource->book_recovered_at : null
            ),
            'book_returned_at' => $this->when(
                condition : !is_null(value :  $this->resource->book_returned_at),
                value : $this->resource->book_returned_at ? $this->resource->book_returned_at : null
            ),
            'created_at' => $this->resource->created_at->format("Y-m-d"),
            'updated_at' => $this->resource->updated_at->format("Y-m-d"),
            'withdraw_at' => $this->when(
                condition : !is_null(value :  $this->resource->withdraw_at),
                value : $this->resource->withdraw_at ? $this->resource->withdraw_at : null
            ),
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
