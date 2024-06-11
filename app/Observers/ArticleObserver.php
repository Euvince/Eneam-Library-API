<?php

namespace App\Observers;

use App\Models\Article;
use Illuminate\Auth\AuthManager;

class ArticleObserver
{

    public function __construct(
        private readonly AuthManager $auth
    )
    {
    }

    private function canDoEvent () : bool {
        return !app()->runningInConsole() && $this->auth->check();
    }

    public function creating(Article $article): void
    {
        $article->slug = \Illuminate\Support\Str::slug($article->title);
        $this->canDoEvent()
            ? $article->created_by = $this->auth->user()->firstname . " " . $this->auth->user()->lastname
            : $article->created_by = NULL;
    }

    /**
     * Handle the Article "created" event.
     */
    public function created(Article $article): void
    {
        //
    }


    public function updating(Article $article): void
    {
        $article->slug = \Illuminate\Support\Str::slug($article->title);
        $this->canDoEvent()
            ? $article->updated_by = $this->auth->user()->firstname . " " . $this->auth->user()->lastname
            : $article->updated_by = NULL;
    }

    /**
     * Handle the Article "updated" event.
     */
    public function updated(Article $article): void
    {
        //
    }


    public function deleting(Article $article): void
    {
        $this->canDoEvent()
            ? $article->deleted_by = $this->auth->user()->firstname . " " . $this->auth->user()->lastname
            : $article->deleted_by = NULL;
        $article->save();
    }

    /**
     * Handle the Article "deleted" event.
     */
    public function deleted(Article $article): void
    {
        //
    }

    /**
     * Handle the Article "restored" event.
     */
    public function restored(Article $article): void
    {
        //
    }

    /**
     * Handle the Article "force deleted" event.
     */
    public function forceDeleted(Article $article): void
    {
        //
    }
}
