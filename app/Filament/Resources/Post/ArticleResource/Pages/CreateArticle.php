<?php

namespace App\Filament\Resources\Post\ArticleResource\Pages;

use App\Constant\PostType;
use App\Filament\Resources\Post\ArticleResource;
use Filament\Resources\Pages\CreateRecord;

class CreateArticle extends CreateRecord
{
    protected static string $resource = ArticleResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();
        $data['type'] = PostType::Article;

        return $data;
    }
}
