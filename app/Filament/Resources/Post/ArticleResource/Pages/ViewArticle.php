<?php

namespace App\Filament\Resources\Post\ArticleResource\Pages;

use App\Constant\Post\PostStatus;
use App\Filament\Resources\Post\ArticleResource;
use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;

class ViewArticle extends ViewRecord
{
    protected static string $resource = ArticleResource::class;

    protected function getActions(): array
    {
        /** @var User $auth */
        $auth = auth()->user();

        return [
            Action::make('pinned')
                ->label('置顶')
                ->color('success')
                ->requiresConfirmation()
                ->action(fn(Post $record) => $record->update(['pinned_at' => Carbon::now()]))
                ->visible(fn(Post $record): bool => ($auth->isAdministrator() || $auth->isEditor()) && $record->status === PostStatus::Published && !$record->isPinned()),
            Action::make('取消置顶')
                ->color('danger')
                ->requiresConfirmation()
                ->action(fn(Post $record) => $record->update(['pinned_at' => null]))
                ->visible(fn(Post $record): bool => ($auth->isAdministrator() || $auth->isEditor()) && $record->isPinned()),
            Action::make('驳回')
                ->color('danger')
                ->requiresConfirmation()
                ->action(fn(Post $record) => $record->update(['status' => PostStatus::Rejected]))
                ->visible(fn(Post $record): bool => ($auth->isAdministrator() || $auth->isEditor()) & $record->status == PostStatus::Published),
        ];
    }
}
