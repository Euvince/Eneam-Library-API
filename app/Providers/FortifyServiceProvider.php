<?php

namespace App\Providers;

use APP\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Laravel\Fortify\Fortify;
use App\Actions\Fortify\CreateNewUser;
use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use Illuminate\Support\Facades\RateLimiter;
use App\Http\Responses\Auth\{
    LoginResponse as AuthLoginResponse,
    LogoutResponse as AuthLogoutResponse,
    RegisterResponse as AuthRegisterResponse,
    PasswordResetResponse as AuthPasswordResetResponse,
    PasswordUpdateResponse as AuthPasswordUpdateResponse,
    ProfileInformationUpdatedResponse as AuthProfileInformationUpdatedResponse
};
use Laravel\Fortify\Contracts\{
    LoginResponse, LogoutResponse, PasswordResetResponse, PasswordUpdateResponse,
    ProfileInformationUpdatedResponse, RegisterResponse
};
use App\Actions\Fortify\UpdateUserProfileInformation;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->instance(abstract : LoginResponse::class, instance : new AuthLoginResponse());
        $this->app->instance(abstract : LogoutResponse::class, instance : new AuthLogoutResponse());
        $this->app->instance(abstract : RegisterResponse::class, instance : new AuthRegisterResponse());
        // POUR L'OPTION MOT DE PASSE OUBLIÉ ? LORS DE LA CONNEXION
        $this->app->instance(abstract : PasswordResetResponse::class, instance : new AuthPasswordResetResponse());
        // POUR MODIFIER SON MOT DE PASSE UNE FOIS CONNECTÉ (AU NIVEAU DU PROFILE PAR EXEMPLE)
        $this->app->instance(abstract : PasswordUpdateResponse::class, instance : new AuthPasswordUpdateResponse());
        // POUR MODIFIER LES INFORMATIONS DU PROFILE
        $this->app->instance(abstract : ProfileInformationUpdatedResponse::class, instance : new AuthProfileInformationUpdatedResponse());
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        
        /* Fortify::authenticateUsing(function (Request $request) {
            $user = User::where('email', $request->email->first());

            if ($user &&
                \Illuminate\Support\Facades\Hash::check($request->password, $user->password) &&
                User::hasAccess($user) && User::hasPaid($user)
            ) return $user;
        }); */

        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())).'|'.$request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

        /* Fortify::verifyEmailView(); */

    }
}
