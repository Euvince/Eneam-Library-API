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
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendFilingReportMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        private readonly string $file,
        private readonly string $name,
        private readonly string $email,
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
            subject: 'Fiche de dépôt de votre mémoire',
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
            markdown: 'mail.send-filing-report-mail',
            with: [
                'sm' => $this->sm,
                'name' =>$this->name,
                'manager' => $manager,
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
        return [
            Attachment::fromPath(path : $this->file)
                ->as(name : 'FICHE DE DÉPÔT DE MÉMOIRE.pdf')
                /* ->withMime('application/docx') */
        ];
    }
}
