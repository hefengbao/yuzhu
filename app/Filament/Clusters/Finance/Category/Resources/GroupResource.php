<?php

namespace App\Filament\Clusters\Finance\Category\Resources;

use App\Constant\Finance\FinanceType;
use App\Filament\Clusters\Finance\Category;
use App\Filament\Clusters\Finance\Category\Resources\GroupResource\Pages\CreateGroup;
use App\Filament\Clusters\Finance\Category\Resources\GroupResource\Pages\EditGroup;
use App\Filament\Clusters\Finance\Category\Resources\GroupResource\Pages\ListGroups;
use App\Filament\Clusters\Finance\Category\Resources\GroupResource\RelationManagers;
use App\Models\Finance\Group;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class GroupResource extends Resource
{
    protected static ?string $model = Group::class;
    protected static ?string $modelLabel = '组别';
    protected static ?string $pluralModelLabel = '组别';

    protected static ?string $cluster = Category::class;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('type')
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
                TextColumn::make('name')
                    ->label('名称'),
                TextColumn::make('type')
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
            'index' => ListGroups::route('/'),
            'create' => CreateGroup::route('/create'),
            'edit' => EditGroup::route('/{record}/edit'),
        ];
    }
}
