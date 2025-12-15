<?php

namespace App\Filament\Clusters\FMS\CategoryTag\Resources\Categories;

use App\Filament\Clusters\FMS\CategoryTag\CategoryTagCluster;
use App\Filament\Clusters\FMS\CategoryTag\Resources\Categories\Pages\CreateCategory;
use App\Filament\Clusters\FMS\CategoryTag\Resources\Categories\Pages\EditCategory;
use App\Filament\Clusters\FMS\CategoryTag\Resources\Categories\Pages\ListCategories;
use App\Filament\Clusters\FMS\CategoryTag\Resources\Categories\Schemas\CategoryForm;
use App\Filament\Clusters\FMS\CategoryTag\Resources\Categories\Schemas\CategoryInfolist;
use App\Filament\Clusters\FMS\CategoryTag\Resources\Categories\Tables\CategoriesTable;
use App\Models\FMS\Category;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;
    protected static ?string $modelLabel = '一级分类';
    protected static ?string $pluralModelLabel = '一级分类';
    protected static ?string $cluster = CategoryTagCluster::class;

    public static function form(Schema $schema): Schema
    {
        return CategoryForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return CategoryInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CategoriesTable::configure($table);
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
            ->whereNull('parent_id')
            ->orderByDesc('id');
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCategories::route('/'),
            'create' => CreateCategory::route('/create'),
            //'view' => ViewCategory::route('/{record}'),
            'edit' => EditCategory::route('/{record}/edit'),
        ];
    }
}
