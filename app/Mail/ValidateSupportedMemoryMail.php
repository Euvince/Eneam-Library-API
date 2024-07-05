<?php

namespace App\Mail;

use App\Models\SupportedMemory;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ValidateSupportedMemoryMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        private readonly string $name,
        private readonly string $email,
        private readonly string $attachment,
        private readonly SupportedMemory $sm,
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
            subject : 'Validation de dépôt de mémoire soutenu.',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.validate-supported-memory-mail',
            with: ['name' => $this->name , 'sm' => $this->sm]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [
            Attachment::fromPath(path : $this->attachment)
                ->as(name : 'FICHE DE DÉPÔT DE MÉMOIRE.docx')
                /* ->withMime('application/docx') */
        ];
    }
}
