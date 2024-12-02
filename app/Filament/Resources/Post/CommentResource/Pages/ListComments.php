<?php

namespace App\Filament\Resources\Post\CommentResource\Pages;

use App\Constant\CommentStatus;
use App\Filament\Resources\Post\CommentResource;
use App\Models\Comment;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;

class ListComments extends ListRecords
{
    protected static string $resource = CommentResource::class;

    public function getTabs(): array
    {
        return [
            '所有' => Tab::make()
                ->badge(
                    Comment::query()
                        ->count()
                )
                ->badgeColor('info'),
            '发布' => Tab::make()
                ->modifyQueryUsing(
                    fn($query) => $query->where('status', CommentStatus::Approved)
                )
                ->badge(
                    Comment::query()
                        ->where('status', CommentStatus::Approved)
                        ->count()
                )
                ->badgeColor('success'),
            '待审' => Tab::make()
                ->modifyQueryUsing(
                    fn($query) => $query->where('status', CommentStatus::Pending)
                )
                ->badge(
                    Comment::query()
                        ->where('status', CommentStatus::Pending)
                        ->count()
                )
                ->badgeColor('warning'),
            '垃圾评论' => Tab::make()
                ->modifyQueryUsing(
                    fn($query) => $query->where('status', CommentStatus::Spam)
                )
                ->badge(
                    Comment::query()
                        ->where('status', CommentStatus::Spam)
                        ->count()
                )
                ->badgeColor('danger'),
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            //Actions\CreateAction::make()
        ];
    }
}
