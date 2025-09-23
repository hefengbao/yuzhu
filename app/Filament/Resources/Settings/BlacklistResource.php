<?php

namespace App\Filament\Resources\Settings;

use App\Constant\BlacklistType;
use App\Filament\Resources\Settings\BlacklistResource\Pages\CreateBlacklist;
use App\Filament\Resources\Settings\BlacklistResource\Pages\EditBlacklist;
use App\Filament\Resources\Settings\BlacklistResource\Pages\ListBlacklists;
use App\Filament\Resources\Settings\BlacklistResource\RelationManagers;
use App\Models\Settings\Blacklist;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class BlacklistResource extends Resource
{
    protected static ?string $model = Blacklist::class;
    protected static ?string $modelLabel = '黑名单';
    protected static ?string $pluralModelLabel = '黑名单';
    protected static ?string $navigationLabel = '黑名单';
    protected static string|\UnitEnum|null $navigationGroup = '设置';
    protected static ?int $navigationSort = 2;

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->isAdministrator();
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('type')
                    ->label('类型')
                    ->options(BlacklistType::class)
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('body')
                    ->label('内容')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('type')->label('类型')->badge(),
                TextColumn::make('body')->label('内容'),
                TextColumn::make('created_at')->label('时间')->date('Y-m-d'),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('body', '!=', BlacklistType::ContentMd5)
            ->orderBy('id', 'desc');
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
            'index' => ListBlacklists::route('/'),
            'create' => CreateBlacklist::route('/create'),
            'edit' => EditBlacklist::route('/{record}/edit'),
        ];
    }
}
