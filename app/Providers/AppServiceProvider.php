<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Opcodes\LogViewer\Facades\LogViewer;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFour();
        Carbon::setLocale('zh');
        JsonResource::withoutWrapping();

        \Blade::if('roles', function (array $roles) {
            return in_array(auth()->user()->role, $roles);
        });

        LogViewer::auth(function ($request) {
            return $request->user()->isAdministrator();
        });

        Gate::policy(\App\Models\Finance\Category::class, \App\Policies\Finance\CategoryPolicy::class);
    }
}
