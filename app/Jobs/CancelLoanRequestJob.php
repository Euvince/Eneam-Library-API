<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use App\Mail\CancelLoanRequestMail;
use App\Models\Article;
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
    public function handle(): void
    {
        if ($this->loan->book_recovered_at === NULL) {
            Article::find($this->loan->article_id)->update([
                'available_stock' => ++ $this->loan->article->available_stock
            ]);
            Mail::send(new CancelLoanRequestMail($this->loan));
        }else return;
    }
}
