<?php

namespace App\Console\Commands;

use App\Jobs\RemindTheUserOfTheEndOfHerLoanRequestJob;
use App\Models\Loan;
use Illuminate\Support\Carbon;
use Illuminate\Console\Command;
use Log;

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
        $time1 = Carbon::parse(Carbon::now()->addMinutes(1))->format("Y-m-d H:i:s");
        $time2 = Carbon::parse(Carbon::now()->addMinutes(3))->format("Y-m-d H:i:s");
        $loans = Loan::whereNotNull('book_recovered_at')->whereBetween('book_must_returned_on', [
            $time1, $time2
        ])->get();

        foreach ($loans as $loan) {
            RemindTheUserOfTheEndOfHerLoanRequestJob::dispatch($loan);
        }
    }
}
