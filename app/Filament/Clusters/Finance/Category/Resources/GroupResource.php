<?php

namespace App\Filament\Clusters\Finance\Category\Resources;

use App\Constant\Finance\FinanceType;
use App\Filament\Clusters\Finance\Category;
use App\Filament\Clusters\Finance\Category\Resources\GroupResource\Pages;
use App\Filament\Clusters\Finance\Category\Resources\GroupResource\RelationManagers;
use App\Models\Finance\Group;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class GroupResource extends Resource
{
    protected static ?string $model = Group::class;
    protected static ?string $modelLabel = '组别';
    protected static ?string $pluralModelLabel = '组别';

    protected static ?string $cluster = Category::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('type')
                    ->label('类型')
                    ->options(FinanceType::class)
                    ->required()
                    ->columnSpanFull(),
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
                Tables\Columns\TextColumn::make('name')
                    ->label('名称'),
                Tables\Columns\TextColumn::make('type')
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
            'index' => Pages\ListGroups::route('/'),
            'create' => Pages\CreateGroup::route('/create'),
            'edit' => Pages\EditGroup::route('/{record}/edit'),
        ];
    }
}
