<?php

namespace App\Filament\Resources\Post\TweetResource\RelationManagers;

use App\Filament\Clusters\Post\Comment\Resources\ApprovedResource;
use Filament\Forms\Form;
use Filament\Infolists\Infolist;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Actions;
use Filament\Tables\Table;

class CommentsRelationManager extends RelationManager
{
    protected static string $relationship = 'comments';

    protected static ?string $title = '评论';

    public function form(Form $form): Form
    {
        return ApprovedResource::form($form);
    }

    public function table(Table $table): Table
    {
        return ApprovedResource::table($table)
            ->modelLabel('评论')
            ->pluralModelLabel('评论')
            ->headerActions([
                Actions\CreateAction::make()->mutateFormDataUsing(function (array $data): array {
                    $data['ip'] = request()->ip();
                    $data['user_id'] = auth()->id();

                    return $data;
                }),
            ]);
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return ApprovedResource::infolist($infolist);
    }
}
