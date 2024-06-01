<?php

namespace App\Observers;

use App\Models\Sector;
use Illuminate\Auth\AuthManager;

class SectorObserver
{

    public function __construct(
        private readonly AuthManager $auth
    )
    {
    }

    private function canDoEvent () : bool {
        return !app()->runningInConsole() && $this->auth->check();
    }


    public function creating(Sector $sector): void
    {
        $attributs = ['type', 'name'];
        foreach ($attributs as $attribut) {
            $sector->$attribut = \App\Helpers::mb_ucfirst($sector->$attribut);
        }
        $sector->acronym = mb_strtoupper(string : $sector->acronym);
        $sector->slug = \Illuminate\Support\Str::slug($sector->name);
        if (mb_strtolower($sector->type) === mb_strtolower('Filière')) $sector->sector_id = NULL;
        $this->canDoEvent()
            ? $sector->created_by = $this->auth->user()->firstname . " " . $this->auth->user()->lastname
            : $sector->created_by = NULL;
    }

    /**
     * Handle the Sector "created" event.
     */
    public function created(Sector $sector): void
    {
        //
    }


    public function updating(Sector $sector): void
    {
        $attributs = ['type', 'name'];
        foreach ($attributs as $attribut) {
            $sector->$attribut = \App\Helpers::mb_ucfirst($sector->$attribut);
        }
        $sector->acronym = mb_strtoupper(string : $sector->acronym);
        $sector->slug = \Illuminate\Support\Str::slug($sector->name);
        if (mb_strtolower($sector->type) === mb_strtolower('Filière')) $sector->sector_id = NULL;
        $this->canDoEvent()
            ? $sector->updated_by = $this->auth->user()->firstname . " " . $this->auth->user()->lastname
            : $sector->updated_by = NULL;
    }

    /**
     * Handle the Sector "updated" event.
     */
    public function updated(Sector $sector): void
    {
        //
    }


    public function deleting(Sector $sector): void
    {
        $this->canDoEvent()
            ? $sector->deleted_by = $this->auth->user()->firstname . " " . $this->auth->user()->lastname
            : $sector->deleted_by = NULL;
        $sector->save();
    }

    /**
     * Handle the Sector "deleted" event.
     */
    public function deleted(Sector $sector): void
    {
        //
    }

    /**
     * Handle the Sector "restored" event.
     */
    public function restored(Sector $sector): void
    {
        //
    }

    /**
     * Handle the Sector "force deleted" event.
     */
    public function forceDeleted(Sector $sector): void
    {
        //
    }
}
