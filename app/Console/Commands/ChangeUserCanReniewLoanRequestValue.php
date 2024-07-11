<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Auth\AuthManager;
use App\Services\LoansOperationsService;

class ChangeUserCanReniewLoanRequestValue extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:change-user-can-reniew-loan-request-value';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "
        Une tâche qui se chargera de changer dynamiquement
        la possibilité pour l'utilisateur de renouveller ou pas
        une demande d'emprunt par le biais de l'attribut can_reniew_loan_request
    ";

    /**
     * Execute the console command.
     */
    public function handle(AuthManager $auth) : void
    {
        if ($auth->check()) {
            /**
            * @var \App\Models\User $user
             */
            $user = $auth->user();

            foreach (\App\Models\Loan::all() as $loan) {
                if (LoansOperationsService::userCanReniewLoanRequest($loan, $user)) {
                    $user->update([
                        'can_reniew_loan_request' => true
                    ]);
                }
            }
        }
    }
}
