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
        \App\Models\Role::class => \App\Policies\RolePolicy::class,
        \App\Models\Loan::class => \App\Policies\LoanPolicy::class,
        \App\Models\User::class => \App\Policies\UserPolicy::class,
        \App\Models\Cycle::class => \App\Policies\CyclePolicy::class,
        \App\Models\Sector::class => \App\Policies\SectorPolicy::class,
        \App\Models\Article::class => \App\Policies\ArticlePolicy::class,
        \App\Models\Comment::class => \App\Policies\CommentPolicy::class,
        \App\Models\Payment::class => \App\Policies\PaymentPolicy::class,
        \App\Models\RoleType::class => \App\Policies\RoleTypePolicy::class,
        \App\Models\SchoolYear::class => \App\Policies\SchoolYearPolicy::class,
        \App\Models\Soutenance::class => \App\Policies\SoutenancePolicy::class,
        \App\Models\Permission::class => \App\Policies\PermissionPolicy::class,
        \App\Models\Reservation::class => \App\Policies\ReservationPolicy::class,
        \App\Models\FilingReport::class => \App\Policies\FilingReportPolicy::class,
        \App\Models\Subscription::class => \App\Policies\SubscriptionPolicy::class,
        \App\Models\Configuration::class => \App\Policies\ConfigurationPolicy::class,
        \App\Models\SupportedMemory::class => \App\Policies\SupportedMemoryPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}
