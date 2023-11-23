<?php

namespace App\Filament\Resources\Post\TweetResource\Pages;

use App\Filament\Resources\Post\TweetResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTweets extends ListRecords
{
    protected static string $resource = TweetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
