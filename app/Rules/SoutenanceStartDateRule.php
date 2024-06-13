<?php

namespace App\Rules;

use Closure;
use Exception;
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
        $scId = $this->request->school_year_id;
        $sc = \App\Models\SchoolYear::find($scId);

        try {
            if (!in_array(
                    (string)\Carbon\Carbon::parse($this->request->start_date)->year,
                    explode("-", $sc->school_year)
                )
            ) $fail("La date de début doit respecter l'année scolaire choisie");
        }catch (\ErrorException $e) {
            throw new Exception($e->getMessage());
        }

        /* if ((boolean)$sc === false) $fail("Année scolaire invalide");
        else {
            if (!in_array(
                    (string)\Carbon\Carbon::parse($this->request->start_date)->year,
                    explode("-", \App\Models\SchoolYear::find($scId)->school_year)
                )
            ) $fail("La date de début doit respecter l'année scolaire choisie");
        } */
    }
}
