<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Policies\BookPolicy;

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
        // Registrar les polítiques d'autorització
        Gate::define('manage-users', function (User $user) {
            return $user->isSuperAdmin();
        });

        // Gate per a gestionar vídeos
        Gate::define('manage-videos', function (User $user) {
            return $user->hasRole('video-manager') || $user->hasRole('super-admin');
        });
    }
}
