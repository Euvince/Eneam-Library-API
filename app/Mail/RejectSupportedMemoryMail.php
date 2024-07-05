<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use App\Models\SupportedMemory;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Queue\ShouldQueue;

class RejectSupportedMemoryMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        private readonly string $name,
        private readonly string $email,
        private readonly string $reason,
        private readonly SupportedMemory $sm
    )
    {
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            to : env('MAIL_TO_ADDRESS'),
            /* to : [$this->email], */
            subject : 'Rejet de dépôt de mémoire soutenu.',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $manager = User::query()
            ->whereHas(relation : 'roles', callback : function (Builder $query) {
                $query->where('name', "Gestionnaire");
            })
            ->where('firstname', 'AKOMIA')
            ->first();

        return new Content(
            markdown: 'mail.reject-supported-memory-mail',
            with: [
                'sm' => $this->sm,
                'name' =>$this->name,
                'manager' => $manager,
                'reason' => $this->reason,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
