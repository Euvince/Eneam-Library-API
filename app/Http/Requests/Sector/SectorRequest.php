<?php

namespace App\Http\Requests\Sector;

use Illuminate\Validation\Rule;
use App\Rules\SameSpecialityForSector;
use App\Rules\ValueInValuesRequestRules;
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
        $routeName = request()->route()->getName();

        if ($routeName === "sector.store" || $routeName === "sector.update") {
            $rules = [
                'type' => [
                    'required',
                    new ValueInValuesRequestRules(
                        request : request(),
                        message : "Le type doit être 'Filière' ou 'Spécialité'.",
                        values : ['Filière', 'Spécialité']
                    )
                ],
                'name' => ['required', new SameSpecialityForSector(request())],
                'acronym' => ['required'],
                'sector_id' => [
                    Rule::requiredIf(fn () => mb_strtolower($this->type) == mb_strtolower("Spécialité")),
                    Rule::exists(table : 'sectors', column : 'id')
                ]
            ];
            if (mb_strtolower($this->type) === mb_strtolower('Filière'))
            $rules['name'] = [
                'required', new SameSpecialityForSector(request()),
                Rule::unique(table : 'sectors', column : 'name')
                ->where(function ($query) {
                    return $query->where('type',  'Filière');
                })
                ->ignore(request()->route()->parameter(name : 'sector'))
                ->withoutTrashed()
            ];
        }

        else if ($routeName === "destroy-sectors") {
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
        if ($routeName === "destroy-sectors") {
            $messages['ids.required'] = "Veuillez sélectionnés une ou plusieurs filière(s)/spécialité(s)";
            $messages['ids.array'] = "L'ensemble de filière(s)/spécialité(s) envoyé doit être un tableau";
        }
        return $messages;
    }

}
