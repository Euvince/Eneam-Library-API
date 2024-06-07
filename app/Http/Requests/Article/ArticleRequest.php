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
            'available_stock' => ['required', 'numeric', 'min:1'],
            'has_ebooks' => ['nullable', 'boolean'],
            'has_audios' => ['nullable', 'boolean'],
            'keywords' => ['required', 'array'],
            'thumbnails_paths' => ['nullable'],
            'access_paths' => ['required',/*  'array',  */'mimes:pdf,epub,mobi'],
            'school_year_id' => ['required', Rule::exists(table : 'school_years', column : 'id')],
        ];

        if (request()->has('thumbnails_paths') && request()->thumbnail !== NULL)
        $rules['thumbnails_paths'] = ['file', 'mimes:png,jpg,jpeg'];

        if (request()->has('has_audios') && request()->has_audios === true)
        $rules['access_paths'] = ['required',/*  'array', */ 'mimes:pdf,epub,mobi,mp3'];

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
        return [
            'editing_year.date_format' => "L'année d'édition n'est pas une année valide",
            'thumbnails_paths.file' => "La couverture du livre doit être un fichier",
            'thumbnails_paths.mimes' => "La couverture du livre doit être un fichier de type : png, jpg ou jpeg",
            'has_ebooks.required' => "Vous devez précisez si le livre possède ou pas d'e-book",
            'has_audios.required' => "Vous devez précisez si le livre possède ou pas d'audio",
        ];
    }

}
