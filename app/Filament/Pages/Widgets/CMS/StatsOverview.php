<?php

namespace App\Filament\Pages\Widgets\CMS;

use App\Enums\CMS\CommentStatus;
use App\Enums\CMS\PostStatus;
use App\Enums\CMS\PostType;
use App\Models\CMS\Comment;
use App\Models\CMS\Post;
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
}
