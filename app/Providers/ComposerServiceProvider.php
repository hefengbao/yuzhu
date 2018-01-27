<?php

namespace App\Providers;


use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        view()->composer('*', 'App\Http\ViewComposers\OptionComposer');
        view()->composer('layouts.partials.widgets.hot_topic', 'App\Http\ViewComposers\HotTopicComposer');
        view()->composer('layouts.partials.nav', 'App\Http\ViewComposers\MenuComposer');
        view()->composer('layouts.partials.widgets.category', 'App\Http\ViewComposers\CategoryComposer');
        view()->composer('layouts.partials.widgets.tag', 'App\Http\ViewComposers\TagComposer');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
