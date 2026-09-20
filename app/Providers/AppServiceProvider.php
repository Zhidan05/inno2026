<?php

namespace App\Providers;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Spatie\Permission\Models\Role;

class AppServiceProvider extends ServiceProvider
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
        // Vercel terminates HTTPS at the reverse proxy.
        // Force Laravel to generate HTTPS URLs in production.
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        Gate::before(function (User $user, string $ability, array $arguments = []) {
            if (! $user->hasRole(UserRole::ADMIN->value)) {
                return null;
            }

            // Do not bypass authorization for role management.
            if (str_ends_with($ability, '_role')) {
                return null;
            }

            // Filament policies may pass the model class or instance
            // as the first authorization argument.
            $model = $arguments[0] ?? null;

            if ($model === Role::class || $model instanceof Role) {
                return null;
            }

            return true;
        });
    }
}