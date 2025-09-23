<?php

namespace App\Services;

use App\Models\Settings\Option;
use Cache;

class OptionService
{
    public function autoload(): array
    {
        return Cache::remember('autoload_options', 24 * 60 * 60, function () {
            return Option::where('autoload', 'yes')->pluck('value', 'name')->all();
        });
    }

    public function options(): array
    {
        return Option::where('autoload', 'yes')->pluck('value', 'name')->all();
    }
}
