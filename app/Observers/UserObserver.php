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

        if (!app()->runningInConsole()) {
            if ($user->comments()->count() > 0) {
                $user->comments()->each(function (\App\Models\Comment $comment) {
                    $comment->delete();
                });
            }

            if ($user->loans()->count() > 0) {
                $user->loans()->each(function (\App\Models\Loan $loan) {
                    $loan->delete();
                });
            }

            if ($user->supportedMemories()->count() > 0) {
                $user->supportedMemories()->each(function (\App\Models\SupportedMemory $memory) {
                    $memory->delete();
                });
            }

            if ($user->reminders()->count() > 0) {
                $user->reminders()->each(function (\App\Models\Reminder $reminder) {
                    $reminder->delete();
                });
            }
        }
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
