<?php

namespace App\Jobs;

use App\Mail\ValidateSupportedMemoryMail;
use Illuminate\Bus\Queueable;
use App\Models\SupportedMemory;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;

class ValidateSupportedMemoryJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /* public $deletingWhenMissingModels = true; */

    /* private SupportedMemory $supportedMemory; */

    /**
     * Create a new job instance.
     */
    public function __construct(
        private readonly SupportedMemory $supportedMemory
    ){
        /* $this->supportedMemory = $supportedMemory->withoutRelations(); */
    }

    /**
     * Execute the job.
     */
    public function handle() : void
    {
        $firstAuthorFullName = $this->supportedMemory->first_author_firstname." ".$this->supportedMemory->first_author_lastname;
        $emails[$firstAuthorFullName] = $this->supportedMemory->first_author_email;

        $secondAuthorFullName = $this->supportedMemory->second_author_firstname." ".$this->supportedMemory->second_author_lastname;
        $emails[$secondAuthorFullName] = $this->supportedMemory->second_author_email;

        foreach ($emails as $name => $email) {
            Mail::send(new ValidateSupportedMemoryMail($name, $email, $this->supportedMemory));
        }
    }
}
