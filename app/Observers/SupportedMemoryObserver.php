<?php

namespace App\Observers;

use App\Helpers;
use App\Models\SupportedMemory;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\Request;

class SupportedMemoryObserver
{
    public function __construct(
        private readonly Request $request,
        private readonly AuthManager $auth
    )
    {
    }

    private function canDoEvent () : bool {
        return !app()->runningInConsole() && $this->auth->check();
    }


    public function creating(SupportedMemory $supportedMemory): void
    {
        $supportedMemory->status = "Invalidé";
        $supportedMemory->slug = \Illuminate\Support\Str::slug($supportedMemory->theme);

        if (!app()->runningInConsole() && isset($this->request->first_author_phone))
        $supportedMemory->first_author_phone = Helpers::formatPhoneNumber($this->request->first_author_phone);

        if (!app()->runningInConsole() && isset($this->request->second_author_phone))
        $supportedMemory->second_author_phone = Helpers::formatPhoneNumber($this->request->second_author_phone);

        $this->canDoEvent()
            ? $supportedMemory->created_by = $this->auth->user()->firstname . " " . $this->auth->user()->lastname
            : $supportedMemory->created_by = NULL;
    }

    /**
     * Handle the SupportedMemory "created" event.
     */
    public function created(SupportedMemory $sm): void
    {
    }


    public function updating(SupportedMemory $supportedMemory): void
    {
    }

    /**
     * Handle the SupportedMemory "updated" event.
     */
    public function updated(SupportedMemory $sm): void
    {
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
