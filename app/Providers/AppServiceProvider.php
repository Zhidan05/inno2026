<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

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
        \Illuminate\Support\Facades\Gate::before(function (\App\Models\User $user, string $ability, array $arguments = []) {
            if ($user->hasRole(\App\Enums\UserRole::ADMIN->value)) {
                // Do not bypass authorization for role management.
                if (str_ends_with($ability, '_role')) {
                    return null; 
                }
                
                // Filament policies pass the model class or instance as the first argument.
                // Explicitly deny bypassing RolePolicy methods (viewAny, view, create, etc.)
                $model = $arguments[0] ?? null;
                if ($model === \Spatie\Permission\Models\Role::class || $model instanceof \Spatie\Permission\Models\Role) {
                    return null;
                }
                
                return true;
            }
            return null;
        });
    }
}
