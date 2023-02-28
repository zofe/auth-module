<?php

namespace Zofe\Auth;


use App\Actions\Fortify\ResetUserPassword;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Actions\AttemptToAuthenticate;
use Laravel\Fortify\Actions\EnsureLoginIsNotThrottled;
use Laravel\Fortify\Actions\PrepareAuthenticatedSession;
use Laravel\Fortify\Actions\RedirectIfTwoFactorAuthenticatable;
use Laravel\Fortify\Contracts\LogoutResponse;
use Laravel\Fortify\Features;
use Laravel\Fortify\Fortify;


class AuthServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/permission.php' => config_path('permission.php'),
                __DIR__ . '/../config/fortify.php' => config_path('fortify.php'),
            ], 'config');

        }

//        $lang_prefix = '';
//        $locale = request()->segment(1);
//
//        if (in_array($locale, config('app.locales'))) {
//            $lang_prefix = ($locale !== config('app.fallback_locale')) ? $locale : '';
//
//            if ($lang_prefix) {
//                session(['lang_prefix' => $lang_prefix]);
//            }
//            app()->setlocale($locale);
//        }
//
//        Route::group([
//            'namespace' => 'Laravel\Fortify\Http\Controllers',
//            'domain' => config('fortify.domain', null),
//            'prefix' => $lang_prefix, //config('fortify.prefix'),
//        ], function () {
//            $this->loadRoutesFrom(base_path('routes/fortify.php'));
//        }); // this closure

        Fortify::loginView(function () {
            return view('auth::auth.login');
        });
        Fortify::twoFactorChallengeView(function () {
            return view('auth::auth.two-factor-challenge');
        });

        Fortify::authenticateThrough(function (Request $request) {
            return array_filter([
                config('fortify.limiters.login') ? null : EnsureLoginIsNotThrottled::class,
                Features::enabled(Features::twoFactorAuthentication()) ? RedirectIfTwoFactorAuthenticatable::class : null,
                AttemptToAuthenticate::class,
                PrepareAuthenticatedSession::class,
            ]);
        });

        //Fortify::createUsersUsing(CreateNewUser::class);
        //Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        //Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(5)->by($request->email.$request->ip());
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/permission.php', 'permission');
        $this->mergeConfigFrom(__DIR__ . '/../config/fortify.php', 'fortify');

        Fortify::ignoreRoutes();

        $this->app->instance(LogoutResponse::class, new class implements LogoutResponse
        {
            public function toResponse($request)
            {
//                if (strpos($request->headers->get('referer'), 'some/bypassed/url')) {
//                    return redirect($request->headers->get('referer'));
//                }

                return redirect('/');
            }
        });


    }
}
