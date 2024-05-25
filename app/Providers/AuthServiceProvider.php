<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        'App\Models\Role' => 'App\Policies\RolePolicy',
        'App\Models\Loan' => 'App\Policies\LoanPolicy',
        'App\Models\User' => 'App\Policies\UserPolicy',
        'App\Models\Cycle' => 'App\Policies\CyclePolicy',
        'App\Models\Sector' => 'App\Policies\SectorPolicy',
        'App\Models\Article' => 'App\Policies\ArticlePolicy',
        'App\Models\Comment' => 'App\Policies\CommentPolicy',
        'App\Models\Payment' => 'App\Policies\PaymentPolicy',
        'App\Models\RoleType' => 'App\Policies\RoleTypePolicy',
        'App\Models\Soutenance' => 'App\Policies\SoutenancePolicy',
        'App\Models\Permission' => 'App\Policies\PermissionPolicy',
        'App\Models\Reservation' => 'App\Policies\ReservationPolicy',
        'App\Models\FilingReport' => 'App\Policies\FilingReportPolicy',
        'App\Models\Subscription' => 'App\Policies\SubscriptionPolicy',
        'App\Models\Configuration' => 'App\Policies\ConfigurationPolicy',
        'App\Models\SupportedMemory' => 'App\Policies\SupportedMemoryPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}
