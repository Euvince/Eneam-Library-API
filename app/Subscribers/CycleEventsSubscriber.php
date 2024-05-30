<?php

namespace App\Subscribers;

use Illuminate\Auth\AuthManager;
use Illuminate\Events\Dispatcher;
use App\Events\Cycle\CycleCreatingEvent;
use App\Events\Cycle\CycleDeletingEvent;
use App\Events\Cycle\CycleUpdatingEvent;

class CycleEventsSubscriber
{

    public function __construct(
        private readonly AuthManager $auth
    )
    {
    }

    private function canDoEvent () : bool {
        return !app()->runningInConsole() && $this->auth->check();
    }

    public function creatingCycle (CycleCreatingEvent $event) : void {
        $event->cycle->code = strtoupper(string : $event->cycle->code);
        $event->cycle->slug = \Illuminate\Support\Str::slug($event->cycle->name);
        $this->canDoEvent()
            ? $event->cycle->created_by = $this->auth->user()->firstname . " " . $this->auth->user()->lastname
            : $event->cycle->created_by = NULL;
    }

    public function updatingCycle (CycleUpdatingEvent $event) : void {
        $event->cycle->code = strtoupper(string : $event->cycle->code);
        $event->cycle->slug = \Illuminate\Support\Str::slug($event->cycle->name);
        $this->canDoEvent()
            ? $event->cycle->updated_by = $this->auth->user()->firstname . " " . $this->auth->user()->lastname
            : $event->cycle->updated_by = NULL;
    }

    public function deletingCycle (CycleDeletingEvent $event) : void {
        $this->canDoEvent()
            ? $event->cycle->deleted_by = $this->auth->user()->firstname . " " . $this->auth->user()->lastname
            : $event->cycle->deleted_by = NULL;
        $event->cycle->save();
    }

    public function subscribe (Dispatcher $dispatcher) : array {
        return [
            CycleCreatingEvent::class => 'creatingCycle',
            CycleUpdatingEvent::class => 'updatingCycle',
            CycleDeletingEvent::class => 'deletingCycle',
        ];
        // Autre syntaxe
        /* $dispatcher->listen(
            CycleCreatingEvent::class, [
                CycleEventsSubscriber::class => 'creatingCycle'
            ],
            CycleUpdatingEvent::class, [
                CycleEventsSubscriber::class => 'updatingCycle'
            ],
            CycleDeletingEvent::class, [
                CycleEventsSubscriber::class => 'deletingCycle'
            ]
        ); */
    }
}
