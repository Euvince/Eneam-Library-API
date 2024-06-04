<?php

namespace App\Http\Requests\SupportedMemory;

use App\Rules\SupportedMemoryThemeRules;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class DepositSupportedMemoryRequest extends FormRequest
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
        return [
            'theme' => ['required', new SupportedMemoryThemeRules()],
            'start_at' => ['required', 'date_format:H:i', 'before:ends_at'],
            'ends_at' => ['required', 'date_format:H:i', 'after:start_at'],
            'first_author_firstname' => ['required'],
            'second_author_firstname' => ['required'],
            'first_author_email' => ['required', 'email'],
            'first_author_lastname' => ['required'],
            'second_author_lastname' => ['required'],
            'second_author_email' => ['required', 'email'],
            'first_author_phone' => ['required', 'phone:INTERNATIONAL'],
            'second_author_phone' => ['required', 'phone:INTERNATIONAL'],
            'jury_president_name' => ['required'],
            'memory_master_name' => ['required'],
            'memory_master_email' => ['required', 'email'],
            'file_path' => ['required', 'mimes:pdf', 'file', 'max:5000000'],
            'cover_page_path' => ['required', 'file', 'max:2000000'],
            'sector_id' => [
                'required',
                Rule::exists(table : 'sectors', column : 'id')
            ],
            'soutenance_id' => [
                'required',
                Rule::exists(table : 'soutenances', column : 'id')
            ]
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
        return [
            "start_at.before" => "L'heure de début doit être antérieure à celle de fin",
            "ends_at.after" => "L'heure de fin doit être postérieure à celle de début",
            "first_author_phone" => "Le numéro de téléphone du premier étudiant n'est pas valide",
            "second_author_phone" => "Le numéro de téléphone du deuxième étudiant n'est pas valide",
        ];
    }

}
