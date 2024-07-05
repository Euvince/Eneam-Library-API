<?php

namespace App\Http\Requests\SupportedMemory;

use Illuminate\Foundation\Http\FormRequest;

class ImportRequest extends FormRequest
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
            'files' => ['required']
        ];
    }

    public function messages() : array {
        return [
            "files.required" => "Le(s) fichier(s) à importer est requis.",
            "files.files" => "Le(s) fichier(s) à importer doit être un fichier valide.",
            /* "files.mimes" => "Le(s) fichier(s) à importer doit/doivent être de type : csv, xlsx.", */
            /* "files.max" => "Le(s) fichier(s) à importer ne peut/peuvent dépasser 10mo.", */
        ];
    }
}
