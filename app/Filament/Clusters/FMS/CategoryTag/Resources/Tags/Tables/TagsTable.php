<?php

namespace App\Filament\Clusters\FMS\CategoryTag\Resources\Tags\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class TagsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('type')
                    ->label('收支类型')
                    ->badge(),
                TextColumn::make('category.parent.name')
                    ->label('一级分类'),
                TextColumn::make('category.name')
                    ->label('二级分类'),
                TextColumn::make('name')
                    ->label('名称')
                    ->searchable(),
            ])
            ->filters([
                SelectFilter::make('parent')
                    ->label('一级分类')
                    ->relationship('category.parent', 'name', fn(Builder $query) => $query->whereNull('parent_id')),
                SelectFilter::make('category')
                    ->label('二级分类')
                    ->relationship('category', 'name', fn(Builder $query) => $query->whereNotNull('parent_id')),
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
