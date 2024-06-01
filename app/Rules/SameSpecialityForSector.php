<?php

namespace App\Rules;

use App\Models\Sector;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Contracts\Validation\ValidationRule;


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
        if (mb_strtolower($this->request->type) === mb_strtolower('Spécialité')) {
            $specialities = $this->request->route()->getName() === 'sector.store'
                ? Sector::find($this->request->sector_id)->specialities
                : Sector::find($this->request->sector_id)->specialities->where('id', '!=', $this->request->route()->parameter('sector')['id']);
            $specialities->each(function ($speciality) use ($fail) {
                if (mb_strtolower($speciality->name) === mb_strtolower($this->request->name)) {
                    $fail('Cette spécialité existe déjà pour le secteur spécifié.');
                }
            });
        }
    }
}
