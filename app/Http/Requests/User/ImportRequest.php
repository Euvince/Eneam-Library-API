<?php

namespace App\Http\Requests\User;

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
            'file' => ['required', 'file', 'mimetypes:text/csv,text/plain,application/csv']
            // 'file' => ['required', 'file', 'mimetypes:text/csv,text/plain,application/csv,xlsx'/* , 'max:10240' */]
        ];
    }

    public function messages() : array {
        return [
            "file.required" => "Le fichier à importer est requis.",
            "file.file" => "Le fichier à importer doit être un fichier valide.",
            "file.mimetypes" => "Le fichier à importer doit être un fichier csv.",
            /* "file.mimes" => "Le fichier à importer doit être de type : csv, xlsx.", */
            /* "file.max" => "Le fichier à importer ne peut dépasser 10mo.", */
        ];
    }

}
