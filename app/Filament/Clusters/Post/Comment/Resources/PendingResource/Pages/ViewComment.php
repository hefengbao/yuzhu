<?php

namespace App\Filament\Clusters\Post\Comment\Resources\PendingResource\Pages;

use App\Constant\BlacklistType;
use App\Constant\Post\CommentStatus;
use App\Filament\Clusters\Post\Comment\Resources\PendingResource;
use App\Models\Blacklist;
use App\Models\Comment;
use App\Models\User;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;

class ViewComment extends ViewRecord
{
    protected static string $resource = PendingResource::class;

    protected function getActions(): array
    {
        /** @var User $auth */
        $auth = auth()->user();

        return [
            Action::make('发布')
                ->color('success')
                ->requiresConfirmation()
                ->action(function (Comment $record) use ($auth) {
                    $record->update(['status' => CommentStatus::Approved]);
                })
                ->visible(fn(Comment $record) => $record->status === CommentStatus::Pending),
            Actions\DeleteAction::make()
                ->visible(fn(Comment $record) => $record->status === CommentStatus::Spam),
            Action::make('标记为垃圾评论')
                ->color('danger')
                ->requiresConfirmation()
                ->action(function (Comment $record) {
                    $record->update(['status' => CommentStatus::Spam]);

                    Blacklist::firstOrCreate([
                        'type' => BlacklistType::Ip,
                        'body' => $record->ip
                    ]);

                    if ($record->guest_email) {
                        Blacklist::firstOrCreate([
                            'type' => BlacklistType::Email,
                            'body' => $record->guest_email
                        ]);

                    }
                })
                ->visible(fn(Comment $record) => $record->status !== CommentStatus::Spam && ($auth->isAdministrator() || $auth->isEditor()))
        ];
    }
}
