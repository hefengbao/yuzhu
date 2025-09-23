<?php

namespace App\Filament\Resources\CMS\ArticleResource\RelationManagers;

use App\Filament\Clusters\CMS\Comment\Resources\ApprovedResource;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class CommentsRelationManager extends RelationManager
{
    protected static string $relationship = 'comments';

    protected static ?string $title = '评论';

    public function form(Schema $schema): Schema
    {
        return ApprovedResource::form($schema);
    }

    public function table(Table $table): Table
    {
        return ApprovedResource::table($table)
            ->modelLabel('评论')
            ->pluralModelLabel('评论')
            ->headerActions([
                CreateAction::make()
                    ->visible(fn(): bool => $this->ownerRecord->isPublished())
                    ->mutateDataUsing(function (array $data): array {
                        $data['ip'] = request()->ip();
                        $data['user_id'] = auth()->id();

                        return $data;
                    }),
            ]);
    }

    public function infolist(Schema $schema): Schema
    {
        return ApprovedResource::infolist($schema);
    }
}
