<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Mail\NotifyLoanRequestToManagerMail;
use App\Mail\NotifyLoanRequestToBorrowerMail;

class NotifyLoanRequestJob implements ShouldQueue
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
        Mail::send(new NotifyLoanRequestToManagerMail($this->loan));
        Mail::send(new NotifyLoanRequestToBorrowerMail($this->loan));
    }
}
