<?php

namespace App\Observers;

use Illuminate\Http\Request;
use App\Models\Configuration;
use Illuminate\Auth\AuthManager;

class ConfigurationObserver
{

    public function __construct(
        private readonly Request $request,
        private readonly AuthManager $auth,
    )
    {
    }

    private function canDoEvent () : bool {
        return !app()->runningInConsole() && $this->auth->check();
    }

    public function creating(Configuration $configuration): void
    {
    }

    /**
     * Handle the Configuration "created" event.
     */
    public function created(Configuration $configuration): void
    {
    }

    public function updating(Configuration $configuration): void
    {
        if (!app()->runningInConsole() && $this->request->has('school_acronym')) {
            $configuration->school_acronym = mb_strtoupper(string : $configuration->school_acronym);
        }
        $this->canDoEvent()
            ? $configuration->updated_by = $this->auth->user()->firstname . " " . $this->auth->user()->lastname
            : $configuration->updated_by = NULL;
    }

    /**
     * Handle the Configuration "updated" event.
     */
    public function updated(Configuration $configuration): void
    {
    }

    public function deleting(Configuration $configuration): void
    {
        $this->canDoEvent()
            ? $configuration->deleted_by = $this->auth->user()->firstname . " " . $this->auth->user()->lastname
            : $configuration->deleted_by = NULL;
        $configuration->save();
    }

    /**
     * Handle the Configuration "deleted" event.
     */
    public function deleted(Configuration $configuration): void
    {
        //
    }

    /**
     * Handle the Configuration "restored" event.
     */
    public function restored(Configuration $configuration): void
    {
        //
    }

    /**
     * Handle the Configuration "force deleted" event.
     */
    public function forceDeleted(Configuration $configuration): void
    {
        //
    }
}
