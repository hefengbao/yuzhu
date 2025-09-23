<?php

namespace App\Filament\Resources\Post\TweetResource\Pages;

use App\Filament\Resources\Post\TweetResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTweet extends EditRecord
{
    protected static string $resource = TweetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
