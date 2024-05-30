<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Request;

class SameSpecialityForSector implements ValidationRule
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
        $divisions = $this->request->route()->getName() === 'sector.store'
                ? Service::find($this->request->service_id)->divisions
                : Service::find($this->request->service_id)->divisions->where('id', '!=', $this->request->route()->parameter('division')['id']);
        $divisions->each(function ($division) use ($fail) {
            if (strtolower($division->division) === strtolower($this->request->division)) {
                $fail('Cette Division existe déjà pour le service spécifié.');
            }
        });
    }
}
