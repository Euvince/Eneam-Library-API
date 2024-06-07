<?php

namespace App\Rules;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Contracts\Validation\ValidationRule;

class SoutenanceStartDateRule implements ValidationRule
{
    public function __construct(
        private readonly Request $request
    )
    {
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!in_array(
               (string)\Carbon\Carbon::parse($this->request->start_date)->year,
                explode("-", \App\Models\SchoolYear::find($this->request->school_year_id)->school_year)
            )
        ) $fail("La date de début doit respecter l'année scolaire choisie");
    }
}
