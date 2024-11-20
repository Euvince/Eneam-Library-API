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
            'theme' => ['required', /* new SupportedMemoryThemeRules(request()) */],
            'start_at' => ['required', 'date_format:H:i', 'before:ends_at'],
            'ends_at' => ['required', 'date_format:H:i', 'after:start_at'],
            'first_author_matricule' => ['required', 'digits:8', 'integer'],
            'second_author_matricule' => ['nullable', 'digits:8', 'integer'],
            'first_author_firstname' => ['required'],
            'second_author_firstname' => ['nullable'],
            'first_author_lastname' => ['required'],
            'second_author_lastname' => ['nullable'],
            'first_author_email' => ['required', 'email'],
            'second_author_email' => ['nullable', 'email'],
            'first_author_phone' => ['required', 'phone:INTERNATIONAL'],
            'second_author_phone' => ['nullable', 'phone:INTERNATIONAL'],
            'jury_president_name' => ['required'],
            'memory_master_name' => ['required'],
            'memory_master_email' => ['required', 'email'],
            'file_path' => ['required', 'mimes:pdf', 'file', 'max:5120'],
            'cover_page_path' => ['required', 'mimes:png,jpg,jpeg', 'file', 'max:2048'],
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
            "start_at.before" => "L'heure de début doit être antérieure à celle de fin.",
            "ends_at.after" => "L'heure de fin doit être postérieure à celle de début.",
            "first_author_phone" => "Le numéro de téléphone du premier étudiant n'est pas valide.",
            "second_author_phone" => "Le numéro de téléphone du second étudiant n'est pas valide.",
            "cover_page_path.max" => "La taille du fichier de la page de garde ne peut dépasser 2mo.",
            "file_path.max" => "La taille du fichier du mémoire soutenu ne peut dépassser 5mo.",
        ];
    }

}
