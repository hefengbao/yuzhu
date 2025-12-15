<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use App\Models\FMS\Settings;
use App\Services\FMS\SeedCategory;

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
        (new SeedCategory())->seed($event->user);

        Settings::create([
            'user_id' => $event->user->id,
            'currency_id' => 1
        ]);
    }
}
