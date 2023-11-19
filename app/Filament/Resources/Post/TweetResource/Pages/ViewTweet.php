<?php

namespace App\Filament\Resources\Post\TweetResource\Pages;

use App\Filament\Resources\Post\TweetResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewTweet extends ViewRecord
{
    protected static string $resource = TweetResource::class;

    protected function getActions(): array
    {
        return [
            Actions\EditAction::make()
        ];
    }
}
