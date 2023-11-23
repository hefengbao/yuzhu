<?php

namespace App\Services;

use App\Models\Option;

class OptionService
{
    function autoload(): array
    {
        return \Cache::remember('autoload_options', 24 * 60 * 60, function () {
            return Option::where('autoload', 'yes')->pluck('value', 'name')->all();
        });
    }

    function options(): array
    {
        return Option::where('autoload', 'yes')->pluck('value', 'name')->all();
    }
}
