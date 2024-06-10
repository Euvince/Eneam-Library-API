<?php

namespace App\Observers;

use App\Models\Comment;
use Illuminate\Auth\AuthManager;

class CommentObserver
{

    public function __construct(
        private readonly AuthManager $auth
    )
    {
    }

    private function canDoEvent () : bool {
        return !app()->runningInConsole() && $this->auth->check();
    }


    public function creating(Comment $comment): void
    {
        $this->canDoEvent()
            ? $comment->created_by = $this->auth->user()->firstname . " " . $this->auth->user()->lastname
            : $comment->created_by = NULL;
    }

    /**
     * Handle the Comment "created" event.
     */
    public function created(Comment $comment): void
    {
        //
    }

    public function updating(Comment $comment): void
    {
        $this->canDoEvent()
            ? $comment->updated_by = $this->auth->user()->firstname . " " . $this->auth->user()->lastname
            : $comment->updated_by = NULL;
    }

    /**
     * Handle the Comment "updated" event.
     */
    public function updated(Comment $comment): void
    {
        //
    }


    public function deleting(Comment $comment): void
    {
        $this->canDoEvent()
            ? $comment->deleted_by = $this->auth->user()->firstname . " " . $this->auth->user()->lastname
            : $comment->deleted_by = NULL;
        $comment->save();
    }

    /**
     * Handle the Comment "deleted" event.
     */
    public function deleted(Comment $comment): void
    {
        //
    }

    /**
     * Handle the Comment "restored" event.
     */
    public function restored(Comment $comment): void
    {
        //
    }

    /**
     * Handle the Comment "force deleted" event.
     */
    public function forceDeleted(Comment $comment): void
    {
        //
    }
}
