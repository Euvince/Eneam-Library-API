<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ChangeLoanRequestTitle extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:change-loan-request-title';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "
        Cette tâche se chargera de modifier le titre
        des demandes d'emprunts ayant déjà été traitées
    ";

    /**
     * Execute the console command.
     */
    public function handle() : void
    {
        /**
         * @var \Illuminate\Support\Collection $loans
        */
        $loans = \App\Models\Loan::where('processing_date', '!==', NULL)->get();

        foreach ($loans as $loan) {
            $loan->update(['title' => "Demande d'emprunt pour le Livre".' '.$loan->article->title]);
        }
    }
}
