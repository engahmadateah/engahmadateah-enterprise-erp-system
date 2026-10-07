<?php

namespace App\Providers;

use App\Models\AuditLog;
use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        if ($this->app->isProduction()) {
            URL::forceScheme('https');
        }

        // strong passwords in production, relaxed for local dev / tests
        Password::defaults(fn () => $this->app->isProduction()
            ? Password::min(10)->mixedCase()->numbers()->uncompromised()
            : Password::min(8));

        Event::listen(Login::class, fn ($e) => AuditLog::record('login', $e->user, 'User logged in', userId: $e->user->getAuthIdentifier()));
        Event::listen(Logout::class, fn ($e) => $e->user
            ? AuditLog::record('logout', $e->user, 'User logged out', userId: $e->user->getAuthIdentifier())
            : null);
        Event::listen(Failed::class, fn ($e) => AuditLog::record(
            'login_failed',
            null,
            'Failed login for ' . mb_substr((string) ($e->credentials['email'] ?? 'unknown'), 0, 120),
            userId: null
        ));

        // Super Admin always passes every permission check (@can, can(), permission: middleware)
        // so new permissions never lock the Super Admin out before re-seeding.
        Gate::before(function ($user, $ability) {
            return $user->hasRole('Super Admin') ? true : null;
        });
    }
}
