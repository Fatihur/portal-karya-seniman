<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\KaryaSeni;
use App\Policies\KaryaSeniPolicy;

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
        Gate::policy(KaryaSeni::class, KaryaSeniPolicy::class);
        
        // Gates for menu visibility
        Gate::define('admin-access', function ($user) {
            return $user->isAdmin();
        });
        
        Gate::define('seniman-access', function ($user) {
            return $user->isSeniman();
        });
    }
}
