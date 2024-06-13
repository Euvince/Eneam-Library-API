<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class CycleRequest extends FormRequest
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
        if ($routeName === "cycle.store" || $routeName === "cycle.update") {
            $rules = [
                'name' => [
                    'required',
                    Rule::unique(table : 'cycles', column : 'name')
                        ->ignore(request()->route()->parameter(name : 'cycle'))
                        ->withoutTrashed()
                ],
                'code' => ['required'],
            ];
        }
        else if ($routeName === "destroy-cycles") {
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
        if ($routeName === "destroy-cycles") {
            $messages['ids.required'] = "Veuillez sélectionnés un ou plusieurs cycle(s)";
            $messages['ids.array'] = "L'ensemble de cycle(s) envoyé doit être un tableau";
        }
        return $messages;
    }

}
