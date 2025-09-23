<?php

namespace App\Filament\Resources\CMS\TweetResource\Pages;

use App\Filament\Resources\CMS\TweetResource;
use Filament\Resources\Pages\ViewRecord;

class ViewTweet extends ViewRecord
{
    protected static string $resource = TweetResource::class;

    protected function getActions(): array
    {
        return [];
    }
}
