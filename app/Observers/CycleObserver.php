<?php

namespace App\Observers;

use App\Models\Cycle;

class CycleObserver
{
    /**
     * Handle the Cycle "created" event.
     */
    public function created(Cycle $cycle): void
    {
        //
    }

    /**
     * Handle the Cycle "updated" event.
     */
    public function updated(Cycle $cycle): void
    {
        //
    }

    /**
     * Handle the Cycle "deleted" event.
     */
    public function deleted(Cycle $cycle): void
    {
        //
    }

    /**
     * Handle the Cycle "restored" event.
     */
    public function restored(Cycle $cycle): void
    {
        //
    }

    /**
     * Handle the Cycle "force deleted" event.
     */
    public function forceDeleted(Cycle $cycle): void
    {
        //
    }
}
