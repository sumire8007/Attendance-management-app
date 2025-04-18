<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


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
        Fortify::createUsersUsing(CreateNewUser::class);

        Fortify::registerView(function () {
            return view('auth.staff_register');
        });
        Fortify::loginView(function () {
            return request()->is('admin/*')
            ? view('auth.admin_login')
            :view('auth.staff_login');
        });

        RateLimiter::for('login', function (Request $request) {
            $email = (string) $request->email;
            return Limit::perMinute(10)->by($email . $request->ip());
        });
        Fortify::authenticateUsing(function ($request) {
                if (request()->is('admin/*')) {
                    $manager = \App\Models\Manager::where('email', $request->email)->first();
                    if ($manager && Hash::check($request->password, $manager->password)) {
                        Auth::guard('manager')->login($manager);
                        return $manager;
                    }
                } else {
                    $user = \App\Models\User::where('email', $request->email)->first();
                    if ($user && Hash::check($request->password, $user->password)) {
                        Auth::guard('web')->login($user);
                        return $user;
                    }
                }
            });
        // Fortify::redirects([
        //     'login' => function () {
        //         return request()->is('admin/*') ? '/admin/attendance/list' : '/attendance';
        //     },
        // ]);

    }
}


// Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
// Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
// Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

// RateLimiter::for('login', function (Request $request) {
//     $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())).'|'.$request->ip());

//     return Limit::perMinute(5)->by($throttleKey);
// });

// RateLimiter::for('two-factor', function (Request $request) {
//     return Limit::perMinute(5)->by($request->session()->get('login.id'));
// });
