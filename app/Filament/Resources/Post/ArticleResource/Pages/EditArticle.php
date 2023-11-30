<?php

namespace App\Filament\Resources\Post\ArticleResource\Pages;

use App\Constant\PostStatus;
use App\Filament\Resources\Post\ArticleResource;
use Carbon\Carbon;
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

        if (isset($data['status'])){
            $data['published_at'] = match ($data['status']) {
                PostStatus::Publish => Carbon::now(),
                PostStatus::Future => isset($data['published_at']) ?
                    Carbon::createFromFormat('Y-m-d H:i:s', $data['published_at'])->format('Y-m-d H:i:s') :
                    Carbon::now(),
                default => null
            };
        }

        return $data;
    }
}
