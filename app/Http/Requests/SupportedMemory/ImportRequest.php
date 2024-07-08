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
        $rules = [];

        if (request()->routeIs('import.pdfs.reports'))
        $rules['files.*'] = ['required', 'file', 'mimes:pdf', /* 'max:10' */];
        else if (request()->routeIs('import.words.reports'))
        $rules['files.*'] = ['required', 'file', 'mimes:docx', /* 'max:10' */];

        return $rules;
    }

    public function messages() : array {
        $messages = [];

        $messages['files.*.required'] = "Le(s) fichier(s) à importer est/sont requis.";
        $messages['files.*.file'] = "Le fichier à importer doit être un fichier valide.";

        if (request()->routeIs('import.pdfs.reports')) {
            $messages['files.*.mimes'] = "Chaque fichier doit être de type pdf";
        }

        if (request()->routeIs('import.words.reports')) {
            $messages['files.*.mimes'] = "Chaque fichier doit être de type docx";
        }

        /* if (request()->routeIs('import.pdfs.reports') || request()->routeIs('import.words.reports')) {
            $messages['files.required'] = "Le fichier à importer est requis.";
            $messages['files.file'] = "Le fichier à importer doit être un fichier valide.";
        }
        if ((request()->routeIs('import.pdfs.reports') || request()->routeIs('import.words.reports')) && count(request()->files) > 1) {
            $messages['files.required'] = "Les fichiers à importer sont requis.";
            $messages['files.file'] = "Les fichiers à importer doivent être des fichier valides.";
        }
        if (request()->routeIs('import.pdfs.reports')) {
            $messages['files.mimes'] = "Le fichier doit être de type pdf";
        }
        if (request()->routeIs('import.pdfs.reports') && count(request()->files) > 1) {
            $messages['files.mimes'] = "Les fichiers doivent être de type pdf";
        }
        if (request()->routeIs('import.words.reports')) {
            $messages['files.mimes'] = "Le fichier doit être de type docx";
        }
        if (request()->routeIs('import.words.reports') && count(request()->files) > 1) {
            $messages['files.mimes'] = "Les fichiers doivent être de type docx";
        } */

        return $messages;
    }
}
