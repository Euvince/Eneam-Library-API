<?php

namespace App\Observers;

use App\Models\SupportedMemory;
use Illuminate\Auth\AuthManager;

class SupportedMemoryObserver
{
    public function __construct(
        private readonly AuthManager $auth
    )
    {
    }

    private function canDoEvent () : bool {
        return !app()->runningInConsole() && $this->auth->check();
    }


    public function creating(SupportedMemory $supportedMemory): void
    {
        $supportedMemory->slug = \Illuminate\Support\Str::slug($supportedMemory->name);
        $this->canDoEvent()
            ? $supportedMemory->created_by = $this->auth->user()->firstname . " " . $this->auth->user()->lastname
            : $supportedMemory->created_by = NULL;
    }

    /**
     * Handle the SupportedMemory "created" event.
     */
    public function created(SupportedMemory $supportedMemory): void
    {
        //
    }


    public function updating(SupportedMemory $supportedMemory): void
    {
        $this->canDoEvent()
            ? $supportedMemory->updated_by = $this->auth->user()->firstname . " " . $this->auth->user()->lastname
            : $supportedMemory->updated_by = NULL;
    }

    /**
     * Handle the SupportedMemory "updated" event.
     */
    public function updated(SupportedMemory $supportedMemory): void
    {
        //
    }

    public function deleting(SupportedMemory $supportedMemory): void
    {
        $this->canDoEvent()
            ? $supportedMemory->deleted_by = $this->auth->user()->firstname . " " . $this->auth->user()->lastname
            : $supportedMemory->deleted_by = NULL;
        $supportedMemory->save();
    }

    /**
     * Handle the SupportedMemory "deleted" event.
     */
    public function deleted(SupportedMemory $supportedMemory): void
    {
        //
    }

    /**
     * Handle the SupportedMemory "restored" event.
     */
    public function restored(SupportedMemory $supportedMemory): void
    {
        //
    }

    /**
     * Handle the SupportedMemory "force deleted" event.
     */
    public function forceDeleted(SupportedMemory $supportedMemory): void
    {
        //
    }
}
