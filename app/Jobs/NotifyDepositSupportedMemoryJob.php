<?php

namespace App\Jobs;

use App\Mail\NotifyDepositSupportedMemoryMail;
use App\Models\SupportedMemory;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class NotifyDepositSupportedMemoryJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private readonly SupportedMemory $supportedMemory
    )
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::send(new NotifyDepositSupportedMemoryMail($this->supportedMemory));
    }
}
