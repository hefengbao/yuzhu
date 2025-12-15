<?php

namespace App\Filament\Clusters\FMS\CategoryTag\Resources\Tags;

use App\Filament\Clusters\FMS\CategoryTag\CategoryTagCluster;
use App\Filament\Clusters\FMS\CategoryTag\Resources\Tags\Pages\CreateTag;
use App\Filament\Clusters\FMS\CategoryTag\Resources\Tags\Pages\EditTag;
use App\Filament\Clusters\FMS\CategoryTag\Resources\Tags\Pages\ListTags;
use App\Filament\Clusters\FMS\CategoryTag\Resources\Tags\Schemas\TagForm;
use App\Filament\Clusters\FMS\CategoryTag\Resources\Tags\Schemas\TagInfolist;
use App\Filament\Clusters\FMS\CategoryTag\Resources\Tags\Tables\TagsTable;
use App\Models\FMS\Tag;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class TagResource extends Resource
{
    protected static ?string $model = Tag::class;
    protected static ?string $modelLabel = '标签';
    protected static ?string $pluralModelLabel = '标签';

    protected static ?string $cluster = CategoryTagCluster::class;

    public static function form(Schema $schema): Schema
    {
        return TagForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return TagInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TagsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('user_id', auth()->id())
            ->orderByDesc('id');
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTags::route('/'),
            'create' => CreateTag::route('/create'),
            //'view' => ViewTag::route('/{record}'),
            'edit' => EditTag::route('/{record}/edit'),
        ];
    }
}
