<?php

namespace App\Http\Requests\Article;

use App\Rules\ValueInValuesRequestRules;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class FindArticleByTypeRequest extends FormRequest
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
            'type' => [
                'sometimes', 'required',
                new ValueInValuesRequestRules(
                    request : request(),
                    message : "Le type doit être 'Livre' ou 'Podcast'.",
                    values : ['Livre', 'Podcast']
                )
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

    public function messages() : array {
        return [
            'type.in' => 'Le champ type doit être *Livre* ou *Podcast*.'
        ];
    }

}
