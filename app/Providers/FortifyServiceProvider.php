<?php

namespace App\Providers;

use view;
use Illuminate\Http\Request;
use Laravel\Fortify\Fortify;
use App\Actions\Fortify\CreateNewUser;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use Illuminate\Support\Facades\RateLimiter;
use App\Actions\Fortify\UpdateUserProfileInformation;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $request = request();

        if ($request->is('admin/*')) {
            Config::set('fortify.guard', 'admin');
            Config::set('fortify.passwords', 'admin');
            Config::set('fortify.prefix', 'admin');
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(
            UpdateUserProfileInformation::class
        );
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        RateLimiter::for('login', function (Request $request) {
            $email = (string) $request->email;

            return Limit::perMinute(5)->by($email . $request->ip());
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by(
                $request->session()->get('login.id')
            );
        });
        //  Fortify::viewPrefix('auth.');
        Fortify::loginView(function () {
            if (Config::get('fortify.guard') == 'web') {
                return view('front.auth.login');
            }
            return view('auth.login');
        });

        // Fortify::loginview('auth.login');
        // Fortify::registerView(function () {
        //     return view('auth.register');
        // });
    }
}