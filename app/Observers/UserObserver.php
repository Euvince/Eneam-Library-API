<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Auth\AuthManager;

class UserObserver
{
    public function __construct(
        private readonly AuthManager $auth
    )
    {
    }

    private function canDoEvent () : bool {
        return !app()->runningInConsole() && $this->auth->check();
    }

    public function creating(User $user): void
    {
        $user->slug = \Illuminate\Support\Str::slug($user->firstname." ". $user->lastname);
        $this->canDoEvent()
            ? $user->created_by = $this->auth->user()->firstname . " " . $this->auth->user()->lastname
            : $user->created_by = NULL;
    }

    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        //
    }

    public function updating(User $user): void
    {
        $user->slug = \Illuminate\Support\Str::slug($user->firstname." ". $user->lastname);
        $this->canDoEvent()
            ? $user->updated_by = $this->auth->user()->firstname . " " . $this->auth->user()->lastname
            : $user->updated_by = NULL;
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        //
    }

    public function deleting(User $user): void
    {
        $this->canDoEvent()
            ? $user->deleted_by = $this->auth->user()->firstname . " " . $this->auth->user()->lastname
            : $user->deleted_by = NULL;
        $user->save();
    }


    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        //
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }

}
