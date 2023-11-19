<?php

namespace App\Filament\Resources\Post\ArticleResource\Pages;

use App\Constant\PostStatus;
use App\Filament\Resources\Post\ArticleResource;
use App\Models\Post;
use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewArticle extends ViewRecord
{
    protected static string $resource = ArticleResource::class;

    protected function getActions(): array
    {
        return [
            EditAction::make(),
            Action::make('置顶')
                ->color('success')
                ->requiresConfirmation()
                ->action(fn(Post $record) => $record->update(['pinned_at', Carbon::now()]))
                ->visible(fn(Post $record) => $record->status === PostStatus::Publish),
            Action::make('移到回收站')
                ->color('danger')
                ->requiresConfirmation()
                ->action(fn(Post $record) => $record->update(['status' => PostStatus::Trash]))
                ->visible(fn(Post $record) => $record->status !== PostStatus::Trash),
            DeleteAction::make()->visible(fn(Post $record) => $record->status === PostStatus::Trash)
        ];
    }
}
