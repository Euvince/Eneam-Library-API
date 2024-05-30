<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Http\Request;

class DatesRules implements ValidationRule
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
        if (\Str::contains($this->request->route()->getName(), 'soutenance')) {
            if ($this->request->start_date > $this->request->end_date)
            $fail("La date de début de soutenance doit être antérieure ou égale à celle de fin.");
        }
    }
}
