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
        $userFullName = $this->auth->user()->firstname . " " . $this->auth->user()->lastname;

        $this->canDoEvent()
            ? $article->deleted_by = $userFullName
            : $article->deleted_by = NULL;
        $article->save();

        if (!app()->runningInConsole()) {
            if ($article->comments()->count() > 0) {
                $article->comments()->each(function (\App\Models\Comment $comment) {
                    $comment->delete();
                });
            }

            if ($article->loans()->count() > 0) {
                $article->loans()->each(function (\App\Models\Loan $loan) use ($article, $userFullName) {
                    /* $article->loans()->detach(ids : [$loan->id]); */
                    $article->loans()->updateExistingPivot($loan->id, [
                        'deleted_at' => now(),
                        /* 'deleted_by' => $userFullName */
                    ]);
                    $loan->delete();
                });
            }

            if ($article->keywords()->count() > 0) {
                $article->keywords()->each(function (\App\Models\Keyword $keyword) use ($article, $userFullName) {
                    /* $article->keywords()->detach(ids : [$keyword->id]); */
                    $article->keywords()->updateExistingPivot($keyword->id, [
                        'deleted_at' => now(),
                        /* 'deleted_by' => $userFullName */
                    ]);
                });
            }
        }

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
