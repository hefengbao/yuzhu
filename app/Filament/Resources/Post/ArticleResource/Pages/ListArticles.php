<?php

namespace App\Filament\Resources\Post\ArticleResource\Pages;

use App\Constant\Post\PostStatus;
use App\Constant\Post\PostType;
use App\Filament\Resources\Post\ArticleResource;
use App\Models\Post;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListArticles extends ListRecords
{
    protected static string $resource = ArticleResource::class;

    public function getTabs(): array
    {
        /** @var User $auth */
        $auth = auth()->user();

        return [
            '所有' => Tab::make()
                ->badge(
                    Post::query()
                        ->where('type', PostType::Article)
                        ->when(!$auth->isAdministrator(), function (Builder $query) {
                            $query->where(function (Builder $query) {
                                $query->where('user_id', auth()->id())
                                    ->orWhere(function (Builder $query) {
                                        $query->where('user_id', '!=', auth()->id())
                                            ->where('status', PostStatus::Published);
                                    });
                            });
                        })
                        ->count()
                )
                ->badgeColor('info'),
            '我的' => Tab::make()
                ->modifyQueryUsing(
                    fn(Builder $query) => $query->where('user_id', auth()->id())
                )
                ->badge(
                    Post::query()
                        ->where('type', PostType::Article)
                        ->where('user_id', auth()->id())
                        ->count()
                )
                ->badgeColor('info'),
            '发布' => Tab::make()
                ->modifyQueryUsing(
                    fn(Builder $query) => $query->where('status', PostStatus::Published)
                )->badge(
                    Post::query()
                        ->where('type', PostType::Article)
                        ->where('status', PostStatus::Published)
                        ->count()
                )
                ->badgeColor('info'),
            '置顶' => Tab::make()
                ->modifyQueryUsing(
                    fn(Builder $query) => $query->whereNotNull('pinned_at')
                )->badge(
                    Post::query()
                        ->where('type', PostType::Article)
                        ->whereNotNull('pinned_at')
                        ->count()
                )
                ->badgeColor('primary'),
            '驳回' => Tab::make()
                ->modifyQueryUsing(
                    fn(Builder $query) => $query->where('status', PostStatus::Rejected)
                )->badge(
                    Post::query()
                        ->where('type', PostType::Article)
                        ->where('status', PostStatus::Rejected)
                        ->when(!$auth->isAdministrator(), function ($query) use ($auth) {
                            $query->where('user_id', $auth->id);
                        })
                        ->count()
                )
                ->badgeColor('danger'),
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('写文章')
                ->icon('heroicon-o-pencil-square'),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
