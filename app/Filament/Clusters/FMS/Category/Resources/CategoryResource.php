<?php

namespace App\Filament\Clusters\FMS\Category\Resources;

use App\Constant\FMS\FinanceType;
use App\Filament\Clusters\FMS\Category\Resources\CategoryResource\Pages\CreateCategory;
use App\Filament\Clusters\FMS\Category\Resources\CategoryResource\Pages\EditCategory;
use App\Filament\Clusters\FMS\Category\Resources\CategoryResource\Pages\ListCategories;
use App\Models\FMS\Category;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;
    protected static ?string $modelLabel = '类别';
    protected static ?string $pluralModelLabel = '类别';
    protected static ?string $cluster = \App\Filament\Clusters\FMS\Category::class;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('group_id')
                    ->label('分类')
                    ->required()
                    ->columnSpanFull()
                    ->relationship('group', 'name', fn(Builder $query): Builder => $query->where('user_id', auth()->id()))
                    ->preload()
                    ->createOptionForm([
                        TextInput::make('name')
                            ->label('名称')
                            ->required(),
                        Select::make('type')
                            ->label('类型')
                            ->required()
                            ->options(FinanceType::class),
                    ]),
                TextInput::make('name')
                    ->label('名称')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('group.name')
                    ->label('组别'),
                TextColumn::make('name')
                    ->label('名称'),
                TextColumn::make('items')
                    ->label('条目')
                    ->formatStateUsing(fn(string $state): string => implode(', ', json_decode($state, true)))
                    ->wrap(),
                TextColumn::make('group.type')
                    ->label('类型')
                    ->badge(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                /*Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),*/
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('user_id', auth()->id())
            ->orderBy('group_id');
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
            'index' => ListCategories::route('/'),
            'create' => CreateCategory::route('/create'),
            'edit' => EditCategory::route('/{record}/edit'),
        ];
    }
}
