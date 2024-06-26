<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use App\Mail\CancelLoanRequestMail;
use App\Models\Article;
use App\Models\Loan;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CancelLoanRequestJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private readonly \App\Models\Loan $loan
    )
    {
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        if (!Loan::hasStarted($this->loan)) {
            /**
             * @var Article $article
             */
            $article = Article::find($this->loan->article_id);
            $article->update([
                'available_stock' => ++ $this->loan->article->available_stock
            ]);
            Article::markAsAvailable($article);
            Mail::send(new CancelLoanRequestMail($this->loan));
            $this->loan->delete();
        }else return;
    }
}
