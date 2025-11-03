<?php

namespace App\Providers;

use App\Models\FMS\Tag;
use App\Models\FMS\Account;
use App\Models\FMS\Category;
use App\Models\FMS\Transaction;
use App\Policies\FMS\AccountPolicy;
use App\Policies\FMS\CategoryPolicy;
use App\Policies\FMS\TagPolicy;
use App\Policies\FMS\TransactionPolicy;
use Blade;
use Carbon\Carbon;
use Illuminate\Http\Request;
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

        LogViewer::auth(function (Request $request) {
            return $request->user()->isAdministrator();
        });

        Gate::policy(Account::class, AccountPolicy::class);
        Gate::policy(Category::class, CategoryPolicy::class);
        Gate::policy(Tag::class, TagPolicy::class);
        Gate::policy(Transaction::class, TransactionPolicy::class);
    }
}
