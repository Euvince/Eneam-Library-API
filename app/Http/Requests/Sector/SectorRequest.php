<?php

namespace App\Http\Requests\Sector;

use App\Rules\SameSpecialityForSector;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class SectorRequest extends FormRequest
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
            'name' => [
                'required',
                new SameSpecialityForSector(request()),
                Rule::unique(table : 'sectors', column : 'name')
                    ->ignore($this->route()->parameter(name : 'id'))
                    ->withoutTrashed()
            ],
            'acronym' => ['required'],
            'type' => ['required', Rule::in(array_map('strtolower', ['Filière', 'Spécialité']))],
            'sector_id' => [
                Rule::requiredIf(fn () => strtolower($this->type) == strtolower("Spécialité")),
                Rule::exists(table : 'sectors', column : 'id')
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
            'type.in' => 'Le champ type doit être *Filière* ou *Spécialité*.'
        ];
    }

}
