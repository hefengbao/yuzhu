<?php

namespace App\Filament\Clusters\FMS\CategoryTag\Resources\SubCategories;

use App\Filament\Clusters\FMS\CategoryTag\CategoryTagCluster;
use App\Filament\Clusters\FMS\CategoryTag\Resources\SubCategories\Pages\CreateSubCategory;
use App\Filament\Clusters\FMS\CategoryTag\Resources\SubCategories\Pages\EditSubCategory;
use App\Filament\Clusters\FMS\CategoryTag\Resources\SubCategories\Pages\ListSubCategories;
use App\Filament\Clusters\FMS\CategoryTag\Resources\SubCategories\Schemas\SubCategoryForm;
use App\Filament\Clusters\FMS\CategoryTag\Resources\SubCategories\Tables\SubCategoriesTable;
use App\Models\FMS\Category;
use App\Models\SubCategory;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class SubCategoryResource extends Resource
{
    protected static ?string $model = Category::class;
    protected static ?string $modelLabel = '二级分类';
    protected static ?string $pluralModelLabel = '二级分类';
    protected static ?string $cluster = CategoryTagCluster::class;

    public static function form(Schema $schema): Schema
    {
        return SubCategoryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SubCategoriesTable::configure($table);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('user_id', auth()->id())
            ->whereNotNull('parent_id')
            ->orderByDesc('id');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSubCategories::route('/'),
            'create' => CreateSubCategory::route('/create'),
            'edit' => EditSubCategory::route('/{record}/edit'),
        ];
    }
}
