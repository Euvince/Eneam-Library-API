<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use App\Listeners\SendEmailVerificationListener;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            /* SendEmailVerificationNotification::class, */
            SendEmailVerificationListener::class
        ],
        /* \App\Events\UserCreatingEvent::class => [
            \App\Listeners\UserCreatingListener::class
        ], */
    ];

    /* protected $observers = [
        \App\Models\User::class => [\App\Observers\UserObserver::class],
        \App\Models\Cycle::class => [\App\Observers\CycleObserver::class],
    ]; */

    /* protected $subscribe = [
        \App\Subscribers\CycleEventsSubscriber::class,
    ]; */

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        /* \App\Models\User::observe(classes : \App\Observers\UserObserver::class);
        \App\Models\Cycle::observe(classes : \App\Observers\CycleObserver::class); */
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
