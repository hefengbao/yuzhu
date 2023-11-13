<?php

namespace App\Filament\Resources\Post\ArticleResource\Pages;

use App\Filament\Resources\Post\ArticleResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewArticle extends ViewRecord
{
    protected static string $resource = ArticleResource::class;

    protected function getActions(): array
    {
        return [
            EditAction::make()
        ];
    }
}
