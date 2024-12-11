<?php

namespace App\Filament\Resources\Finance;

use App\Constant\Finance\AccountType;
use App\Filament\Resources\Finance\AccountResource\Pages;
use App\Filament\Resources\Finance\AccountResource\RelationManagers;
use App\Models\Finance\Account;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class AccountResource extends Resource
{
    protected static ?string $model = Account::class;
    protected static ?string $modelLabel = '账户';
    protected static ?string $pluralModelLabel = '账户';

    protected static ?string $navigationGroup = '财务';
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('名称')
                    ->required(),
                Forms\Components\Select::make('type')
                    ->label('类型')
                    ->options(AccountType::class)
                    ->required()
                    ->live(),
                Forms\Components\TextInput::make('balance')
                    ->label('余额')
                    ->numeric()
                    ->inputMode('decimal')
                    ->minValue(0)
                    ->step(0.01)
                    ->default(0.00),
                Forms\Components\TextInput::make('credit_limit')
                    ->label('信用卡额度')
                    ->numeric()
                    ->inputMode('decimal')
                    ->minValue(0)
                    ->hidden(fn(Forms\Get $get) => AccountType::parse($get('type')) !== AccountType::Credit),
                Forms\Components\TextInput::make('settlement_day')
                    ->label('信用卡出账日')
                    ->integer()
                    ->minValue(1)
                    ->maxValue(28)
                    ->hidden(fn(Forms\Get $get) => AccountType::parse($get('type')) !== AccountType::Credit),
                Forms\Components\Select::make('status')
                    ->label('状态')
                    ->default(1)
                    ->options([
                        '0' => '停用',
                        '1' => '启用',
                    ])->required(),
                Forms\Components\Textarea::make('notes')
                    ->label('备注')
                    ->maxLength(100),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('名称'),
                Tables\Columns\TextColumn::make('balance')
                    ->label('余额')->money('CNY'),
                Tables\Columns\TextColumn::make('type')
                    ->label('类型')
                    ->badge(),
                Tables\Columns\TextColumn::make('status')
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
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListAccounts::route('/'),
            'create' => Pages\CreateAccount::route('/create'),
            'edit' => Pages\EditAccount::route('/{record}/edit'),
        ];
    }
}
