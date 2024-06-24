<?php

namespace App\Console\Commands;

use App\Jobs\RemindTheUserOfTheEndOfHerLoanRequestJob;
use App\Models\Loan;
use DateTime;
use DateTimeZone;
use Illuminate\Support\Carbon;
use Illuminate\Console\Command;

class RemindAllUsersOfTheEndOfTheirLoansRequests extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:remind-all-users-of-the-end-of-their-loans-requests';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "
        Cette tâche sera chargée de rappeller aux emprunteurs de
        ramener un Livre deux jours avant la date limite de retour d'un Livre
    ";

    /**
     * Execute the console command.
     */
    public function handle() : void
    {
        $now = Carbon::now();
        $loans = Loan::whereBetween('book_returned_on', [
            $now->addDays(1), $now->addDays(2)
        ])->get();

        foreach ($loans as $loan) {
            RemindTheUserOfTheEndOfHerLoanRequestJob::dispatch(arguments : $loan);
        }
    }
}
