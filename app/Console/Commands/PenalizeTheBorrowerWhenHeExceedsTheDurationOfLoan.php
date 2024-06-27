<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class PenalizeTheBorrowerWhenHeExceedsTheDurationOfLoan extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:penalize-the-borrower-when-he-exceeds-the-duration-of-loan';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "
        Cette tâche se chargera d'incrémenter du montant configuré par le Gestionnaire le
        montant de la dette des emprunteurs pour chaque jour exédant la date de retour du Livre
    ";

    /**
     * Execute the console command.
     */
    public function handle() : void
    {
        $loans = \App\Models\Loan::whereNotNull('book_recovered_at')
            ->where('book_must_returned_on', '<', \Carbon\Carbon::now())
            ->whereNull('book_returned_at')
            ->get();

        foreach ($loans as $loan) {

            /**
             * @var Configuration $config
             */
            $config = \App\Models\Configuration::appConfig();

            /**
             * @var \App\Models\User $user
             */
            $user = $loan->user;

            $debtAmount = $user->hasAnyRole(roles : [
                    'Etudiant-Eneamien', 'Etudiant-Externe'
                ])
                ? $config->student_debt_amount
                : $config->teacher_debt_amount;

            $user->update([
                'has_paid' => false,
                'has_access' => false,
                'debt_amount' => $user->debt_ammout + $debtAmount,
            ]);
        }
    }
}
