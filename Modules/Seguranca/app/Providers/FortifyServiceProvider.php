<?php

namespace Modules\Seguranca\Providers;

use Modules\Seguranca\Actions\Fortify\CreateNewUser;
use Modules\Seguranca\Actions\Fortify\ResetUserPassword;
use Modules\Seguranca\Actions\Fortify\UpdateUserPassword;
use Modules\Seguranca\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Actions\RedirectIfTwoFactorAuthenticatable;
use Laravel\Fortify\Fortify;
use Modules\Seguranca\Entities\Usuarios;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        
        Fortify::username('seg_email');

        Fortify::loginView(function () {
            return view('seguranca::auth.login');
        });

        /*Fortify::registerView(function () {
            return view('seguranca::auth.register');
        });*/
        Fortify::requestPasswordResetLinkView(function () {
            return view('seguranca::auth.forgot-password');
        });
        Fortify::resetPasswordView(function ($request) {
            return view('seguranca::auth.reset-password', ['request' => $request]);
        });
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);
        Fortify::redirectUserForTwoFactorAuthenticationUsing(RedirectIfTwoFactorAuthenticatable::class);

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())).'|'.$request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });
    }
}
