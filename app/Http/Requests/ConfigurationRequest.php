<?php

namespace App\Http\Requests;

use Illuminate\Support\Str;
use Illuminate\Foundation\Http\FormRequest;

class ConfigurationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [];

        $routeName = request()->route()->getName();
        if (Str::contains($routeName, 'school-name')) $rules = ['school_name' => 'required'];
        if (Str::contains($routeName, 'school-acronym')) $rules = ['school_acronym' => 'required'];
        if (Str::contains($routeName, 'school-city')) $rules = ['school_city' => 'required'];
        if (Str::contains($routeName, 'eneamien-subscribe-amount')) $rules = ['eneamien_subscribe_amount' => 'required|numeric|min:0'];
        if (Str::contains($routeName, 'extern-subscribe-amount')) $rules = ['extern_subscribe_amount' => 'required|numeric|min:0'];
        if (Str::contains($routeName, 'subscription-expiration-delay')) $rules = ['subscription_expiration_delay' => 'required|numeric|min:0'];
        if (Str::contains($routeName, 'student-debt-amount')) $rules = ['student_debt_amount' => 'required|numeric|min:0'];
        if (Str::contains($routeName, 'teacher-debt-amount')) $rules = ['teacher_debt_amount' => 'required|numeric|min:0'];
        if (Str::contains($routeName, 'student-loan-delay')) $rules = ['student_loan_delay' => 'required|numeric|min:0'];
        if (Str::contains($routeName, 'teacher-loan-delay')) $rules = ['teacher_loan_delay' => 'required|numeric|min:0'];
        if (Str::contains($routeName, 'student-renewals-number')) $rules = ['student_renewals_number' => 'required|numeric|min:0'];
        if (Str::contains($routeName, 'teacher-renewals-number')) $rules = ['teacher_renewals_number' => 'required|numeric|min:0'];
        if (Str::contains($routeName, 'max-books-per-student')) $rules = ['max_books_per_student' => 'required|numeric|min:0'];
        if (Str::contains($routeName, 'max-books-per-teacher')) $rules = ['max_books_per_teacher' => 'required|numeric|min:0'];
        if (Str::contains($routeName, 'max-copies-books-per-teacher')) $rules = ['max_copies_books_per_student' => 'required|numeric|min:0'];
        if (Str::contains($routeName, 'max-copies-books-per-teacher')) $rules = ['max_copies_books_per_teacher' => 'required|numeric|min:0'];

        return $rules;
    }
}
