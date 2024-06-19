<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CommentRequest extends FormRequest
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

        if (
            $routeName === "article.comment.store" ||
            $routeName === "article.comment.update"
        ) {
            $rules = [
                'content' => ['required']
            ];
        }
        else if ($routeName === "destroy-comments") {
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
        if ($routeName === "destroy-comments") {
            $messages['ids.required'] = "Veuillez sélectionnés un ou plusieurs commentaire(s)";
            $messages['ids.array'] = "L'ensemble de commentaire(s) envoyé doit être un tableau";
        }
        return $messages;
    }

}
