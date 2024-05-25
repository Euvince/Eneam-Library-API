<?php

namespace App\Listeners;

use App\Events\UserCreatingEvent;
use Illuminate\Auth\AuthManager;
use Illuminate\Support\Facades\Auth;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserCreatingListener
{
    /**
     * Create the event listener.
     */
    public function __construct(private readonly AuthManager $auth)
    {
    }

    /**
     * Handle the event.
     */
    public function handle(UserCreatingEvent $event): void
    {
        $event->user->created_by = $this->auth->user()->firstname . " " . $this->auth->user()->lastname;
    }
}
