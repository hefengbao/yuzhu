<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use App\Models\Finance\Settings;
use App\Services\Finance\SeedCategories;

class InitUserSettings
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserRegistered $event): void
    {
        (new SeedCategories())->seed($event->user);

        Settings::create([
            'user_id' => $event->user->id,
            'currency_id' => 1
        ]);
    }
}
