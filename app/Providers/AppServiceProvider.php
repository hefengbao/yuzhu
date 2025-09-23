<?php

namespace App\Providers;

use App\Models\Finance\Account;
use App\Models\Finance\Category;
use App\Models\Finance\Group;
use App\Models\Finance\Transaction;
use App\Policies\Finance\AccountPolicy;
use App\Policies\Finance\CategoryPolicy;
use App\Policies\Finance\GroupPolicy;
use App\Policies\Finance\TransactionPolicy;
use Blade;
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

        Blade::if('roles', function (array $roles) {
            return in_array(auth()->user()->role, $roles);
        });

        LogViewer::auth(function ($request) {
            return $request->user()->isAdministrator();
        });

        Gate::policy(Account::class, AccountPolicy::class);
        Gate::policy(Category::class, CategoryPolicy::class);
        Gate::policy(Group::class, GroupPolicy::class);
        Gate::policy(Transaction::class, TransactionPolicy::class);
    }
}
