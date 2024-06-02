<?php

namespace App\Jobs;

use App\Mail\RejectSupportedMemoryMail;
use App\Models\SupportedMemory;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class RejectSupportedMemoryJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /* public $deletingWhenMissingModels = true; */

    /* private SupportedMemory $supportedMemory; */

    /**
     * Create a new job instance.
     */
    public function __construct(
        private readonly string $reason,
        private readonly SupportedMemory $supportedMemory
    ){
        /* $this->supportedMemory = $supportedMemory->withoutRelations(); */
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $emails[$this->supportedMemory->first_author_name] = $this->supportedMemory->first_author_email;
        $emails[$this->supportedMemory->second_author_name] = $this->supportedMemory->second_author_email;
        foreach ($emails as $name => $email) {
            Mail::send(new RejectSupportedMemoryMail($name, $email, $this->reason, $this->supportedMemory));
        }
    }
}
