<?php

namespace App\Filament\Resources\Post\TweetResource\Pages;

use App\Filament\Resources\Post\TweetResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTweet extends CreateRecord
{
    protected static string $resource = TweetResource::class;
}
