<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Http\Request;

class SoutenanceEndDateRule implements ValidationRule
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
            (string)\Carbon\Carbon::parse($this->request->end_date)->year,
             explode("-", \App\Models\SchoolYear::find($this->request->school_year_id)->school_year)
         )
     ) $fail("La date de fin doit respecter l'année scolaire choisie");
    }
}
