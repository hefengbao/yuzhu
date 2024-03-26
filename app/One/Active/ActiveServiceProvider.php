<?php

namespace App\One\Active;

use Illuminate\Routing\Events\RouteMatched;
use Illuminate\Support\ServiceProvider;

class ActiveServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    public function boot(): void
    {
        // Update the instances each time a request is resolved and a route is matched
        $instance = app('active');
        app('router')->matched(
            function (RouteMatched $event) use ($instance) {
                $instance->updateInstances($event->route, $event->request);
            }
        );
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton(
            'active',
            function ($app) {

                return new Active($app['router']->getCurrentRequest());
            }
        );
    }
}
