<?php

namespace App\Observers;

use App\Models\Cycle;
use Illuminate\Auth\AuthManager;

class CycleObserver
{
    public function __construct(
        private readonly AuthManager $auth
    )
    {
    }

    private function canDoEvent () : bool {
        return !app()->runningInConsole() && $this->auth->check();
    }


    public function creating(Cycle $cycle): void
    {
        $cycle->name = \App\Helpers::mb_ucfirst($cycle->name);
        $cycle->code = mb_strtoupper(string : $cycle->code);
        $cycle->slug = \Illuminate\Support\Str::slug($cycle->name);
        $this->canDoEvent()
            ? $cycle->created_by = $this->auth->user()->firstname . " " . $this->auth->user()->lastname
            : $cycle->created_by = NULL;
    }

    /**
     * Handle the Cycle "created" event.
     */
    public function created(Cycle $cycle): void
    {
    }


    public function updating(Cycle $cycle): void
    {
        $cycle->name = \App\Helpers::mb_ucfirst($cycle->name);
        $cycle->code = mb_strtoupper(string : $cycle->code);
        $cycle->slug = \Illuminate\Support\Str::slug($cycle->name);
        $this->canDoEvent()
            ? $cycle->updated_by = $this->auth->user()->firstname . " " . $this->auth->user()->lastname
            : $cycle->updated_by = NULL;
    }

    /**
     * Handle the Cycle "updated" event.
     */
    public function updated(Cycle $cycle): void
    {
    }


    public function deleting(Cycle $cycle): void
    {
        $this->canDoEvent()
            ? $cycle->deleted_by = $this->auth->user()->firstname . " " . $this->auth->user()->lastname
            : $cycle->deleted_by = NULL;
        $cycle->save();
    }

    /**
     * Handle the Cycle "deleted" event.
     */
    public function deleted(Cycle $cycle): void
    {
    }

    /**
     * Handle the Cycle "restored" event.
     */
    public function restored(Cycle $cycle): void
    {
    }

    /**
     * Handle the Cycle "force deleted" event.
     */
    public function forceDeleted(Cycle $cycle): void
    {
    }

}
