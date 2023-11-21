<?php

namespace App\Filament\Resources\Post\ArticleResource\RelationManagers;

use App\Filament\Resources\Post\CommentResource;
use Filament\Forms\Form;
use Filament\Infolists\Infolist;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Actions;
use Filament\Tables\Table;

class CommentsRelationManager extends RelationManager
{
    protected static string $relationship = 'comments';
    protected static ?string $title = "评论";

    public function form(Form $form): Form
    {
        return CommentResource::form($form);
    }

    public function table(Table $table): Table
    {
        return CommentResource::table($table)
            ->modelLabel('评论')
            ->pluralModelLabel('评论')
            ->headerActions([
                Actions\CreateAction::make()->mutateFormDataUsing(function (array $data): array {
                    $data['ip'] = request()->ip();
                    $data['user_id'] = auth()->id();
                    return  $data;
                })
            ]);
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return CommentResource::infolist($infolist);
    }
}
