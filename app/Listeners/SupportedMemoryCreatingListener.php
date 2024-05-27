<?php

namespace App\Listeners;

use App\Events\SupportedMemoryCreatingEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SupportedMemoryCreatingListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(SupportedMemoryCreatingEvent $event): void
    {
        //
    }
}
