<?php

namespace App\Observers;

use App\Models\Soutenance;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\Request;

class SoutenanceObserver
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


    public function creating(Soutenance $soutenance): void
    {
        if (!app()->runningInConsole()) {
            /* $soutenance->name = \App\Models\Cycle::find($this->request->cycle_id)->name."".\Carbon\Carbon::parse($soutenance->start_date)->year; */
            $soutenance->name = \App\Models\Cycle::find($this->request->cycle_id)->name." ".\App\Models\SchoolYear::find($this->request->school_year_id)->school_year;
            $soutenance->slug = \Illuminate\Support\Str::slug($soutenance->name);
        }
        $this->canDoEvent()
            ? $soutenance->created_by = $this->auth->user()->firstname . " " . $this->auth->user()->lastname
            : $soutenance->created_by = NULL;
    }

    /**
     * Handle the Soutenance "created" event.
     */
    public function created(Soutenance $soutenance): void
    {
    }


    public function updating(Soutenance $soutenance): void
    {
        if (!app()->runningInConsole()) {
            /* $soutenance->name = \App\Models\Cycle::find($this->request->cycle_id)->name."".\Carbon\Carbon::parse($soutenance->start_date)->year; */
            $soutenance->name = \App\Models\Cycle::find($this->request->cycle_id)->name." ".\App\Models\SchoolYear::find($this->request->year_id)->school_year;
            $soutenance->slug = \Illuminate\Support\Str::slug($soutenance->name);
        }
        $this->canDoEvent()
            ? $soutenance->updated_by = $this->auth->user()->firstname . " " . $this->auth->user()->lastname
            : $soutenance->updated_by = NULL;
    }

    /**
     * Handle the Soutenance "updated" event.
     */
    public function updated(Soutenance $soutenance): void
    {
    }


    public function deleting(Soutenance $soutenance): void
    {
        $this->canDoEvent()
            ? $soutenance->deleted_by = $this->auth->user()->firstname . " " . $this->auth->user()->lastname
            : $soutenance->deleted_by = NULL;
        $soutenance->save();
    }

    /**
     * Handle the Soutenance "deleted" event.
     */
    public function deleted(Soutenance $soutenance): void
    {
    }

    /**
     * Handle the Soutenance "restored" event.
     */
    public function restored(Soutenance $soutenance): void
    {
        //
    }

    /**
     * Handle the Soutenance "force deleted" event.
     */
    public function forceDeleted(Soutenance $soutenance): void
    {
        //
    }
}
