<?php

namespace App\Http\Requests\SupportedMemory;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class DepositSupportedMemoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'theme' => ['required'],
            'start_at' => ['required', 'date_format:H:i:s', 'before:ends_at'],
            'ends_at' => ['required', 'date_format:H:i:s', 'after:start_at'],
            'first_author_name' => ['required'],
            'first_author_email' => ['required', 'email'],
            'second_author_name' => ['required'],
            'second_author_email' => ['required', 'email'],
            'first_author_phone' => ['required', 'phone:INTERNATIONAL,BJ'],
            'second_author_phone' => ['required', 'phone:INTERNATIONAL,BJ'],
            'jury_president' => ['required'],
            'memory_master' => ['required'],
            'file_path' => ['required'],
            'cover_page_path' => ['required'],
        ];
    }

    public function failedValidations (Validator $validator) : HttpResponseException {
        throw new HttpResponseException(response()->json([
            'status' => 422,
            'error' => true,
            'success' => false,
            'message' => 'Erreurs de validations des données',
            'errors' => $validator->errors()
        ]));
    }

    public function messages() {
    }

}
