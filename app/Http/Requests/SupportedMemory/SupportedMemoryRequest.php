<?php

namespace App\Http\Requests\SupportedMemory;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class SupportedMemoryRequest extends FormRequest
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
        if ($routeName === "reject-memory") {
            $rules = [
                'reason' => ['required']
            ];
        }
        else if (
            $routeName === "destroy-memories" || $routeName === "validate-memories" ||
            $routeName === "download-memories" || $routeName === "print-reports"
        ) {
            $rules = [
                'ids' => ['required', 'array']
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

    public function messages()  :array {
        $messages = [];
        $routeName = request()->route()->getName();
        if (
            $routeName === "destroy-memories" ||
            $routeName === "validate-memories" ||
            $routeName === "print-reports"
        ) {
            $messages['ids.required'] = "Veuillez sélectionnés un ou plusieurs mémoire(s)";
            $messages['ids.array'] = "L'ensemble de mémoire(s) envoyé doit être un tableau";
        }
        return $messages;
    }

}
