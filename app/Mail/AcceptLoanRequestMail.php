<?php

namespace App\Mail;

use App\Models\User;
use App\Models\Configuration;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Queue\ShouldQueue;

class AcceptLoanRequestMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        private readonly \App\Models\Loan $loan,
    )
    {
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            to : $this->loan->user->email,
            subject: "Confirmation de l'acceptation de votre demande d'emprunt",
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

        /**
         * @var \App\Models\User $user
         */
        $user = $this->loan->user;

        /**
         * @var \App\Models\Configuration $config
         */
        $config = Configuration::appConfig();

        /**
         * @var int $delayValue
         */
        $delayValue = $user->hasAnyRole(roles : [
            'Etudiant-Eneamien', 'Etudiant-Externe',
            ])
            ? $config->student_recovered_delay
            : $config->teacher_recovered_delay;

        return new Content(
            markdown: 'mail.accept-loan-request-mail',
            with : [
                'loan' => $this->loan,
                'manager' => $manager,
                'delayValue' => $delayValue,
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
