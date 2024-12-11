<?php

namespace App\Filament\Widgets\Post;

use App\Constant\CommentStatus;
use App\Constant\PostStatus;
use App\Constant\PostType;
use App\Filament\Pages\FinanceDashboard;
use App\Models\Comment;
use App\Models\Post;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('文章', Post::where('type', PostType::Article)->where('status', PostStatus::Published)->count()),
            Stat::make('微博', Post::where('type', PostType::Tweet)->where('status', PostStatus::Published)->count()),
            Stat::make('页面', Post::where('type', PostType::Page)->where('status', PostStatus::Published)->count()),
            Stat::make('评论', Comment::where('status', CommentStatus::Approved)->count()),
        ];
    }

    protected function getCards(): array
    {
        return [
            FinanceDashboard::class
        ];
    }
}
