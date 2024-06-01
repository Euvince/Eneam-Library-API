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
        return [
            /**
             * The name that you can use.
             * @var string{name: string}
             * @example {"name": "Licence"}
             */
            'name' => [
                'required',
                Rule::unique(table : 'cycles', column : 'name')
                    ->ignore(request()->route()->parameter(name : 'cycle'))
                    ->withoutTrashed()
            ],
            /**
             * The code that you can use.
             * @var string{code: string}
             * @example {"code": "L"}
             */
            'code' => ['required'],
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

}
