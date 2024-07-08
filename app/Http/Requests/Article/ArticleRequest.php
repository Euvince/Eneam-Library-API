<?php

namespace App\Http\Requests\Article;

use Illuminate\Validation\Rule;
use App\Rules\ValueInValuesRequestRules;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ArticleRequest extends FormRequest
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
        $routeName = request()->route()->getName();

        if ($routeName === 'article.store' || $routeName === 'article.update') {
            $rules = [
                /* 'type' => [
                    'sometimes', 'required',
                    new ValueInValuesRequestRules(
                        request : request(),
                        message : "Le type doit être 'Livre' ou 'Podcast'.",
                        values : ['Livre', 'Podcast']
                    )
                ], */
                'title' => ['required'],
                'summary' => ['required'],
                'author' => ['required'],
                'editor' => ['required'],
                'editing_year' => ['required', 'date_format:Y'],
                'cote' => ['required'],
                'number_pages' => ['required', 'numeric', 'min:1'],
                'ISBN' => ['required'],
                'available_stock' => [
                    Rule::requiredIf((boolean) request()->is_physical === true),
                    'numeric', 'min:0'
                ],
                'has_ebooks' => ['nullable', 'boolean'],
                'is_physical' => ['nullable', 'boolean'],
                'has_audios' => ['nullable', 'boolean'],
                'keywords' => ['required', 'array'],
                'thumbnail_path' => ['nullable', 'file', 'mimes:png,jpg,jpeg'/* , 'max:value' */],
                'file_path' => [
                    Rule::requiredIf((boolean) request()->has_ebooks === true),
                    'file', 'mimes:pdf,epub,mobi'/* , 'max:value' */
                ],
                'files_paths' => ['nullable'/* , 'array' */],
                'files_paths.*' => ['file', 'mimes:pdf,epub,mobi'/* , 'max:value' */],
                'school_year_id' => ['required', Rule::exists(table : 'school_years', column : 'id')],
            ];

            if (request()->has('has_audios') && (boolean)request()->has_audios === true) {
                $rules['files_paths'] = ['nullable'/* , 'array' */];
                $rules['files_paths.*'] = ['file', 'mimes:pdf,epub,mobi,mp3'];
            }
        }

        else if ($routeName === "destroy-articles") {
            $rules = [
                'ids' => ['required', 'array'],
            ];
        }

        return $rules;
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

    public function messages() : array {
        $messages = [];
        $routeName = request()->route()->getName();

        if ($routeName === 'article.store' || $routeName === 'article.update') {
            $messages = [
                'editing_year.date_format' => "L'année d'édition n'est pas une année valide",
                'thumbnails_paths.file' => "La couverture du livre doit être un fichier",
                'thumbnails_paths.mimes' => "La couverture du livre doit être un fichier de type : png, jpg ou jpeg",
                'has_ebooks.required' => "Vous devez précisez si le livre possède ou pas d'e-book",
                'has_audios.required' => "Vous devez précisez si le livre possède ou pas d'audio",
                "files_paths.*.max" => "La taille de chaque fichier de livre ne peut dépassser ...",
                "files_paths.*.file" => "Chaque fichier de livre doit être un fichier valide",
                "files_paths.*.mimes" => "Chaque fichier de livre doit être de type : pdf, epub ou mobi.",
            ];
            if (request()->has('has_audios') && (boolean)request()->has_audios === true) {
                $messages['files_paths.*.max'] = "La taille de chaque fichier de livre ne peut dépassser ...";
                $messages['files_paths.*.file'] = "Chaque fichier de livre doit être un fichier valide.";
                $messages['files_paths.*.mimes'] = "Chaque fichier de livre doit être de type : pdf, epub, mobi ou mp3.";
            }
        }

        else if ($routeName === "destroy-articles") {
            $messages['ids.required'] = "Veuillez sélectionnés un ou plusieurs article(s)";
            $messages['ids.array'] = "L'ensemble d'article(s) envoyé doit être un tableau";
        }

        return $messages;
    }

}
