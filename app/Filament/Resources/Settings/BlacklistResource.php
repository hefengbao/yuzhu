<?php

namespace App\Filament\Resources\Settings;

use App\Constant\BlacklistType;
use App\Filament\Resources\Settings\BlacklistResource\Pages;
use App\Filament\Resources\Settings\BlacklistResource\RelationManagers;
use App\Models\Blacklist;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class BlacklistResource extends Resource
{
    protected static ?string $model = Blacklist::class;
    protected static ?string $modelLabel = '黑名单';
    protected static ?string $pluralModelLabel = '黑名单';
    protected static ?string $navigationLabel = '黑名单';
    protected static ?string $navigationGroup = '设置';
    protected static ?int $navigationSort = 2;

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->isAdministrator();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('type')
                    ->label('类型')
                    ->options(BlacklistType::class)
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('body')
                    ->label('内容')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('type')->label('类型')->badge(),
                Tables\Columns\TextColumn::make('body')->label('内容'),
                Tables\Columns\TextColumn::make('created_at')->label('时间')->date('Y-m-d'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
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
            'index' => Pages\ListBlacklists::route('/'),
            'create' => Pages\CreateBlacklist::route('/create'),
            'edit' => Pages\EditBlacklist::route('/{record}/edit'),
        ];
    }
}
