<?php

namespace App\Observers;

use Carbon\Carbon;
use App\Models\Subscription;
use App\Models\Configuration;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\Request;

class SubscriptionObserver
{

    public function __construct(
        private readonly Request $request,
        private readonly AuthManager $auth
    )
    {
    }

    private function canDoEvent () : bool {
        return !app()->runningInConsole() && $this->auth->check();
    }

    public function creating(Subscription $subscription): void
    {
        $config = Configuration::appConfig();

        if (!app()->runningInConsole()) {
            $subscriptonDate = Carbon::parse(Carbon::now()->format("Y-m-d"));
            $subscription->status = "Actif";
            $subscription->subscription_date = $subscriptonDate;
            $subscription->expiration_date = $subscriptonDate->addYears(value : $config->subscription_expiration_delay);
            $amount = $this->request->route()->parameter('user')->hasRole(roles : ['Etudiant-Eneamien'])
                ? $config->eneamien_subscribe_amount
                : $config->extern_subscribe_amount;
            $subscription->amount = $amount;
        }
        $this->canDoEvent()
            ? $subscription->created_by = $this->auth->user()->firstname . " " . $this->auth->user()->lastname
            : $subscription->created_by = NULL;
    }

    /**
     * Handle the Subscription "created" event.
     */
    public function created(Subscription $subscription): void
    {
        //
    }

    /**
     * Handle the Subscription "updated" event.
     */
    public function updated(Subscription $subscription): void
    {
        //
    }

    public function deleting(Subscription $subscription): void
    {
        $this->canDoEvent()
            ? $subscription->deleted_by = $this->auth->user()->firstname . " " . $this->auth->user()->lastname
            : $subscription->deleted_by = NULL;
        $subscription->save();
    }

    /**
     * Handle the Subscription "deleted" event.
     */
    public function deleted(Subscription $subscription): void
    {
        //
    }

    /**
     * Handle the Subscription "restored" event.
     */
    public function restored(Subscription $subscription): void
    {
        //
    }

    /**
     * Handle the Subscription "force deleted" event.
     */
    public function forceDeleted(Subscription $subscription): void
    {
        //
    }
}
