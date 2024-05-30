<?php

namespace App\Observers;

use App\Models\Sector;

class SectorObserver
{
    /**
     * Handle the Sector "created" event.
     */
    public function created(Sector $sector): void
    {
        //
    }

    /**
     * Handle the Sector "updated" event.
     */
    public function updated(Sector $sector): void
    {
        //
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
