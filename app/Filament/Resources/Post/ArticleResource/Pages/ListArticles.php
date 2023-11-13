<?php

namespace App\Filament\Resources\Post\ArticleResource\Pages;

use App\Constant\PostStatus;
use App\Constant\PostType;
use App\Filament\Resources\Post\ArticleResource;
use App\Models\Post;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;

class ListArticles extends ListRecords
{
    protected static string $resource = ArticleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    public function getTabs(): array
    {
        Log::info(auth()->id());
        return [
            '所有' => Tab::make()
                ->badge(
                    Post::query()
                        ->where('type',PostType::Article)
                        ->count()
                )
                ->badgeColor('info'),
            '我的' => Tab::make()
                ->modifyQueryUsing(
                    fn(Builder $query) => $query->where('user_id', auth()->id())
                )->badge(
                    Post::query()
                        ->where('type',PostType::Article)
                        ->where('user_id', auth()->id())
                        ->count()
                )
                ->badgeColor('info'),
            '已发布' => Tab::make()
                ->modifyQueryUsing(
                    fn(Builder $query) => $query->where('status', PostStatus::Publish)
                )->badge(
                    Post::query()
                        ->where('type',PostType::Article)
                        ->where('status', PostStatus::Publish)
                        ->count()
                )
                ->badgeColor('info'),
            '置顶' => Tab::make()
                ->modifyQueryUsing(
                    fn(Builder $query) => $query->whereNotNull('pinned_at')
                )->badge(
                    Post::query()
                        ->where('type',PostType::Article)
                        ->whereNotNull('pinned_at')
                        ->count()
                )
                ->badgeColor('primary'),
            '回收站' => Tab::make()
                ->modifyQueryUsing(
                    fn(Builder $query) => $query->$query->where('status', PostStatus::Trash)
                )->badge(
                    Post::query()
                        ->where('type',PostType::Article)
                        ->where('status', PostStatus::Trash)
                        ->count()
                )
                ->badgeColor('danger'),
        ];
    }
}
