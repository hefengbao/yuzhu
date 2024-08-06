<?php

namespace App\Filament\Resources\Post\ArticleResource\Pages;

use App\Filament\Resources\Post\ArticleResource;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Str;

class EditArticle extends EditRecord
{
    protected static string $resource = ArticleResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (!isset($data['excerpt'])) {
            $data['excerpt'] = Str::limit(str_replace(PHP_EOL, '', strip_tags(md_to_html($data['body']))), 160);
        }

        return $data;
    }
}
