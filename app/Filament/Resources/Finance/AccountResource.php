<?php

namespace App\Filament\Resources\Finance;

use App\Constant\Finance\AccountType;
use App\Filament\Resources\Finance\AccountResource\Pages\CreateAccount;
use App\Filament\Resources\Finance\AccountResource\Pages\EditAccount;
use App\Filament\Resources\Finance\AccountResource\Pages\ListAccounts;
use App\Filament\Resources\Finance\AccountResource\RelationManagers;
use App\Models\Finance\Account;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Support\Colors\Color;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class AccountResource extends Resource
{
    protected static ?string $model = Account::class;
    protected static ?string $modelLabel = '账户';
    protected static ?string $pluralModelLabel = '账户';

    protected static string|\UnitEnum|null $navigationGroup = '财务';
    protected static ?int $navigationSort = 4;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('名称')
                    ->required(),
                Select::make('type')
                    ->label('类型')
                    ->options(AccountType::class)
                    ->required()
                    ->live(),
                TextInput::make('balance')
                    ->label('余额')
                    ->numeric()
                    ->inputMode('decimal')
                    ->minValue(0)
                    ->step(0.01)
                    ->default(0.00),
                TextInput::make('credit_limit')
                    ->label('信用卡额度')
                    ->numeric()
                    ->inputMode('decimal')
                    ->minValue(0)
                    ->hidden(fn(Get $get) => AccountType::parse($get('type')) !== AccountType::Credit),
                TextInput::make('settlement_day')
                    ->label('信用卡出账日')
                    ->integer()
                    ->minValue(1)
                    ->maxValue(28)
                    ->hidden(fn(Get $get) => AccountType::parse($get('type')) !== AccountType::Credit),
                Select::make('status')
                    ->label('状态')
                    ->default(1)
                    ->options([
                        '0' => '停用',
                        '1' => '启用',
                    ])->required(),
                Textarea::make('notes')
                    ->label('备注')
                    ->maxLength(100),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('名称'),
                TextColumn::make('balance')
                    ->label('余额')->money('CNY'),
                TextColumn::make('type')
                    ->label('类型')
                    ->badge(),
                TextColumn::make('status')
                    ->label('状态')
                    ->formatStateUsing(function (bool $state) {
                        if ($state) return '启用'; else return '停用';
                    })
                    ->badge()
                    ->color(function (bool $state) {
                        if ($state) return Color::Green; else return Color::Red;
                    }),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('user_id', auth()->id());
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
            'index' => ListAccounts::route('/'),
            'create' => CreateAccount::route('/create'),
            'edit' => EditAccount::route('/{record}/edit'),
        ];
    }
}
