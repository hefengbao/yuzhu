<?php

namespace App\Filament\Clusters\Post;

use Filament\Clusters\Cluster;

class Comment extends Cluster
{
    protected static ?string $navigationLabel = '评论';
    protected static string|\UnitEnum|null $navigationGroup = '内容';
    protected static ?int $navigationSort = 5;
    protected static ?string $clusterBreadcrumb = '评论';
    protected static ?string $slug = 'post/comments';
}
