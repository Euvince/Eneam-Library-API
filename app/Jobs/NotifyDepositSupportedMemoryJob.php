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
        $firstAuthorFullName = $this->supportedMemory->first_author_firstname." ".$this->supportedMemory->first_author_lastname;
        $emails[$firstAuthorFullName] = $this->supportedMemory->first_author_email;

        $secondAuthorFullName = $this->supportedMemory->second_author_firstname." ".$this->supportedMemory->second_author_lastname;
        $emails[$secondAuthorFullName] = $this->supportedMemory->second_author_email;

        foreach ($emails as $name => $email) {
            Mail::send(new NotifyDepositSupportedMemoryMail($name, $email, $this->supportedMemory));
        }
    }
}
