<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use App\Mail\AcceptLoanRequestMail;
use App\Mail\RejectLoanRequestMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class RejectLoanRequestJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private readonly string $reason,
        private readonly \App\Models\Loan $loan
    )
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::send(new RejectLoanRequestMail($this->loan, $this->reason));
    }
}
