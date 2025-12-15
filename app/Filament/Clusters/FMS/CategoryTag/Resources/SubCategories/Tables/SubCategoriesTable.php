<?php

namespace App\Filament\Clusters\FMS\CategoryTag\Resources\SubCategories\Tables;

use App\Enums\FMS\FinanceType;
use App\Models\FMS\Category;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class SubCategoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('type')
                    ->label('收支类型')
                    ->badge(),
                TextColumn::make('parent.name')
                    ->label('父类'),
                TextColumn::make('name')
                    ->label('名称'),

            ])
            ->filters([
                SelectFilter::make('type')
                    ->label('类型')
                    ->options(FinanceType::class),
                SelectFilter::make('parent_id')
                    ->label('分类')
                    ->options(Category::whereNull('parent_id')->pluck('name', 'id'))
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //DeleteBulkAction::make(),
                ]),
            ]);
    }
}
