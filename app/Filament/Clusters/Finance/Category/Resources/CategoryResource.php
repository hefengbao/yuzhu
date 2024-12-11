<?php

namespace App\Filament\Clusters\Finance\Category\Resources;

use App\Constant\Finance\FinanceType;
use App\Filament\Clusters\Finance\Category\Resources;
use App\Models\Finance\Category;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;
    protected static ?string $modelLabel = '类别';
    protected static ?string $pluralModelLabel = '类别';
    protected static ?string $cluster = \App\Filament\Clusters\Finance\Category::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('group_id')
                    ->label('分类')
                    ->required()
                    ->columnSpanFull()
                    ->relationship('group', 'name', fn(Builder $query): Builder => $query->where('user_id', auth()->id()))
                    ->preload()
                    ->createOptionForm([
                        Forms\Components\TextInput::make('name')
                            ->label('名称')
                            ->required(),
                        Forms\Components\Select::make('type')
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
                Tables\Columns\TextColumn::make('group.name')
                    ->label('组别'),
                Tables\Columns\TextColumn::make('name')
                    ->label('名称'),
                Tables\Columns\TextColumn::make('items')
                    ->label('条目')
                    ->formatStateUsing(fn(string $state): string => implode(', ', json_decode($state, true)))
                    ->wrap(),
                Tables\Columns\TextColumn::make('group.type')
                    ->label('类型')
                    ->badge(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
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
            'index' => Resources\CategoryResource\Pages\ListCategories::route('/'),
            'create' => Resources\CategoryResource\Pages\CreateCategory::route('/create'),
            'edit' => Resources\CategoryResource\Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
