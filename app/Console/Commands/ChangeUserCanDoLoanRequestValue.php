<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use App\Services\LoansOperationsService;
use Illuminate\Auth\AuthManager;

class ChangeUserCanDoLoanRequestValue extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:change-user-can-do-loan-request-value';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "
        Une tâche qui se chargera de changer dynamiquement
        la possibilité pour l'utilisateur d'éffectuer ou pas
        une demande d'emprunt par le biais de l'attribut can_do_loan_request
    ";

    /**
     * Execute the console command.
     */
    public function handle(AuthManager $auth) : void
    {
        /**
         * @var User $user
         */
        $user = $auth->user();

        foreach (\App\Models\Article::all() as $article) {
            if (LoansOperationsService::userCanDoLoanRequest($user, $article)) {
                $user->update([
                    'can_do_loan_request' => true
                ]);
            }
        }
    }
}
