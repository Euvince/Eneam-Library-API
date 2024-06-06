<?php

namespace App\Http\Requests;

use App\Rules\DatesRules;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class SoutenanceRequest extends FormRequest
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
            /* 'year' => ['required', 'integer', 'digits:4', 'max:' . date('Y')], */
            'start_date' => ['required', 'date', /* 'before_or_equal:today', */ 'before_or_equal:end_date'/* , new DatesRules(request()) */],
            'end_date' => ['required', 'date', /* 'before_or_equal:today', */ 'after_or_equal:start_date'],
            'number_memories_expected' => ['required', 'integer', 'min:1'],
            'cycle_id' => ['required', Rule::exists(table : 'cycles', column : 'id')],
            'year_id' => ['required', Rule::exists(table : 'school_years', column : 'id')],
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

    public function messages () : array {
        return [
            'start_date.date' => 'Le champ date de début doit être une date valide.',
            'start_date.before_or_equal' => 'Le champ date de début doit être une date antérieure ou égale à la date de fin.',
            'end_date.date' => 'Le champ date de fin doit être une date valide.',
            'end_date.after_or_equal' => 'Le champ date de fin doit être une date postérieure ou égale à la date de début.',
            'number_memories_expected.required' => "Le nombre de mémoires attendus est obligatoire",
        ];
    }

}
