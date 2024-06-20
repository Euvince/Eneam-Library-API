<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;

class DeleteSubscriptionAfterExpirationDate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-subscription-after-expiration-date';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "
        Cette tâche se charge de mettre fin aux
        abonnements ayant atteint leur date d'expiration
    ";

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $expiredSubscriptions = \App\Models\Subscription::where('expiration_date', '<=', Carbon::parse(Carbon::now()->format("Y-m-d")))->get();

        foreach ($expiredSubscriptions as $subscription) {
            \App\Models\User::find($subscription->user->id)->update([
                'has_paid' => false,
                'has_access' => false,
            ]);
            $subscription->delete();
        }
    }
}
