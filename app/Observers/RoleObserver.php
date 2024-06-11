<?php

namespace App\Observers;

use App\Models\Role;
use Illuminate\Auth\AuthManager;

class RoleObserver
{

    public function __construct(
        private readonly AuthManager $auth
    )
    {
    }

    private function canDoEvent () : bool {
        return !app()->runningInConsole() && $this->auth->check();
    }


    public function creating(Role $role): void
    {
        $role->name = \App\Helpers::mb_ucfirst($role->name);
        $role->slug = \Illuminate\Support\Str::slug($role->name);
        $this->canDoEvent()
            ? $role->created_by = $this->auth->user()->firstname . " " . $this->auth->user()->lastname
            : $role->created_by = NULL;
    }

    /**
     * Handle the Role "created" event.
     */
    public function created(Role $role): void
    {
        //
    }


    public function updating(Role $role): void
    {
        $role->name = \App\Helpers::mb_ucfirst($role->name);
        $role->slug = \Illuminate\Support\Str::slug($role->name);
        $this->canDoEvent()
            ? $role->updated_by = $this->auth->user()->firstname . " " . $this->auth->user()->lastname
            : $role->updated_by = NULL;
    }

    /**
     * Handle the Role "updated" event.
     */
    public function updated(Role $role): void
    {
        //
    }


    public function deleting(Role $role): void
    {
        $this->canDoEvent()
            ? $role->deleted_by = $this->auth->user()->firstname . " " . $this->auth->user()->lastname
            : $role->deleted_by = NULL;
        $role->save();
    }

    /**
     * Handle the Role "deleted" event.
     */
    public function deleted(Role $role): void
    {
        //
    }

    /**
     * Handle the Role "restored" event.
     */
    public function restored(Role $role): void
    {
        //
    }

    /**
     * Handle the Role "force deleted" event.
     */
    public function forceDeleted(Role $role): void
    {
        //
    }
}
