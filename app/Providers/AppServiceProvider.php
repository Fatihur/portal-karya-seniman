<?php

namespace App\Providers;

use App\Models\KaryaSeni;
use App\Policies\KaryaSeniPolicy;
use App\View\Composers\PublicLayoutComposer;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
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
        Gate::policy(KaryaSeni::class, KaryaSeniPolicy::class);

        View::composer('layouts.public', PublicLayoutComposer::class);

        Gate::define('admin-access', function ($user) {
            return $user->isAdmin();
        });

        Gate::define('seniman-access', function ($user) {
            return $user->isSeniman();
        });
    }
}
