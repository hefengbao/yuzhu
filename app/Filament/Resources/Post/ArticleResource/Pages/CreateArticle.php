<?php

namespace App\Filament\Resources\Post\ArticleResource\Pages;

use App\Constant\Post\PostType;
use App\Filament\Resources\Post\ArticleResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;

class CreateArticle extends CreateRecord
{
    protected static string $resource = ArticleResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();
        $data['type'] = PostType::Article;

        if (!isset($data['excerpt'])) {
            $data['excerpt'] = Str::limit(str_replace(PHP_EOL, '', strip_tags(Str::markdown($data['body']))), 160);
        }

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
