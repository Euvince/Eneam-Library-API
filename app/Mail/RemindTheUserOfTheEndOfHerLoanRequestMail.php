<?php

namespace App\Mail;

use App\Models\User;
use App\Models\Configuration;
use App\Services\LoansOperationsService;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Queue\ShouldQueue;

class RemindTheUserOfTheEndOfHerLoanRequestMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        private readonly \App\Models\Loan $loan
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
            /* to : $this->loan->user->email, */
            subject: "Retour imminent de votre emprunt",
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

        /**
         * @var float $delayValue
         */
        $debtAmount = $user->hasAnyRole(roles : [
            'Etudiant-Eneamien', 'Etudiant-Externe',
            ])
            ? $config->student_debt_amount
            : $config->teacher_debt_amount;

        return new Content(
            markdown: 'mail.remind-the-user-of-the-end-of-her-loan-request-mail',
            with : [
                'loan' => $this->loan,
                'manager' => $manager,
                'delayValue' => $delayValue,
                'debtAmount' => $debtAmount,
                'canReniewLoanRequest' => LoansOperationsService::theBorrowerAttemptHerMaxRenewals($this->loan->user, $this->loan)
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
