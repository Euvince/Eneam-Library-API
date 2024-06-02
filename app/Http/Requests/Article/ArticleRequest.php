<?php

namespace App\Http\Requests\Article;

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
        return [
            'type' => ['required'],
            'title' => ['required'],
            'summary' => ['required'],
            'author' => ['required'],
            'editor' => ['required'],
            'editing_year' => ['date_format:Y'],
            'number_pages' => ['required', 'numeric', 'min:1'],
            'ISBN' => ['required'],
            'available_stock' => ['required', 'numeric', 'min:1'],
            'has_ebook' => ['required', 'boolean'],
            'has_podcast' => ['required', 'boolean'],
            'keywords' => ['required'],
            'formats' => ['required'],
            'access_paths' => ['required']
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
        return [];
    }

}
