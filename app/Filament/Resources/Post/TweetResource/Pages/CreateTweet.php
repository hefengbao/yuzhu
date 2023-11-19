<?php

namespace App\Filament\Resources\Post\TweetResource\Pages;

use App\Constant\PostStatus;
use App\Constant\PostType;
use App\Filament\Resources\Post\TweetResource;
use Carbon\Carbon;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;

class CreateTweet extends CreateRecord
{
    protected static string $resource = TweetResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();
        $data['ip'] = request()->ip();
        $data['excerpt'] = Str::limit(str_replace(PHP_EOL, '', strip_tags(md_to_html($data['body']))), 160);
        $data['slug'] = Str::random();
        $data['type'] = PostType::Tweet->value;
        $data['status'] = PostStatus::Publish->value;
        $data['published_at'] = Carbon::now();

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
