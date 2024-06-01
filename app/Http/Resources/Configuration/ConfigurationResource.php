<?php

namespace App\Http\Resources\Configuration;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @configuration Configuration $resource
 */

class ConfigurationResource extends JsonResource
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
            'school_name' => $this->resource->school,
            'school_acronym' => $this->resource->school_acronym,
            'school_city' => $this->resource->school_city,
            'eneamien_subscribe_amount' => $this->resource->eneamien_subscribe_amount,
            'extern_subscribe_amount' => $this->resource->extern_subscribe_amount,
            'student_debt_amount' => $this->resource->student_debt_amount,
            'teacher_debt_amount' => $this->resource->teacher_debt_amount,
            'student_loan_delay' => $this->resource->student_loan_delay,
            'teacher_loan_delay' => $this->resource->teacher_loan_delay,
            'student_renewals_number' => $this->resource->student_renewals_number,
            'teacher_renewals_number' => $this->resource->teacher_renewals_number,
            'max_books_per_student' => $this->resource->max_books_per_student,
            'max_books_per_teacher' => $this->resource->max_books_per_teacher,
            'max_copies_books_per_student' => $this->resource->max_copies_books_per_student,
            'max_copies_books_per_teacher' => $this->resource->max_copies_books_per_teacher,
            'created_at' => $this->resource->created_at->format("Y-m-d"),
            'updated_at' => $this->resource->updated_at->format("Y-m-d"),
            'created_by' => $this->resource->created_by,
            'updated_by' => $this->resource->updated_by,
        ];
    }
}
