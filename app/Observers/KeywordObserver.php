<?php

namespace App\Observers;

use App\Models\Keyword;
use Illuminate\Auth\AuthManager;

class KeywordObserver
{

    public function __construct(
        private readonly AuthManager $auth
    )
    {
    }

    private function canDoEvent () : bool {
        return !app()->runningInConsole() && $this->auth->check();
    }


    public function creating(Keyword $keyword): void
    {
        $keyword->keyword = \App\Helpers::mb_ucfirst($keyword->keyword);
        $this->canDoEvent()
            ? $keyword->created_by = $this->auth->user()->firstname . " " . $this->auth->user()->lastname
            : $keyword->created_by = NULL;
    }

    /**
     * Handle the Keyword "created" event.
     */
    public function created(Keyword $keyword): void
    {
        //
    }

    public function updating (Keyword $keyword): void
    {
        $keyword->keyword = \App\Helpers::mb_ucfirst($keyword->keyword);
        $this->canDoEvent()
            ? $keyword->created_by = $this->auth->user()->firstname . " " . $this->auth->user()->lastname
            : $keyword->created_by = NULL;
    }

    /**
     * Handle the Keyword "updated" event.
     */
    public function updated(Keyword $keyword): void
    {
        //
    }


    public function deleting(Keyword $keyword): void
    {
        $this->canDoEvent()
            ? $keyword->deleted_by = $this->auth->user()->firstname . " " . $this->auth->user()->lastname
            : $keyword->deleted_by = NULL;
        $keyword->save();
    }

    /**
     * Handle the Keyword "deleted" event.
     */
    public function deleted(Keyword $keyword): void
    {
        //
    }

    /**
     * Handle the Keyword "restored" event.
     */
    public function restored(Keyword $keyword): void
    {
        //
    }

    /**
     * Handle the Keyword "force deleted" event.
     */
    public function forceDeleted(Keyword $keyword): void
    {
        //
    }
}
