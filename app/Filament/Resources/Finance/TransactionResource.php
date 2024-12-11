<?php

namespace App\Filament\Resources\Finance;

use App\Constant\Finance\FinanceType;
use App\Filament\Resources\Finance\TransactionResource\Pages;
use App\Filament\Resources\Finance\TransactionResource\RelationManagers;
use App\Models\Finance\Group;
use App\Models\Finance\Transaction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $modelLabel = '收支';
    protected static ?string $pluralModelLabel = '收支';

    protected static ?string $navigationGroup = '财务';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        $settings = auth()->user()->financeSettings;

        return $form
            ->schema([
                Forms\Components\Select::make('account_id')
                    ->label('账户')
                    ->relationship(
                        'account',
                        'name',
                        fn(Builder $query) => $query->where('user_id', auth()->id())
                    )
                    ->required(),
                Forms\Components\DatePicker::make('date')
                    ->label('日期')
                    ->format('Y-m-d')
                    ->displayFormat('Y-m-d')
                    ->default(date('Y-m-d'))
                    ->required(),
                Forms\Components\Select::make('type')
                    ->label('类别')
                    ->options(FinanceType::class)
                    ->required()
                    ->live(),
                Forms\Components\Select::make('category_id')
                    ->label('类型')
                    ->options(function (Forms\Get $get) {
                        return Group::with('categories')
                            ->where('type', $get('type'))
                            ->get()
                            ->pluck('categories', 'name')
                            ->map(function ($items) {
                                return $items->pluck('name', 'id');
                            })
                            ->toArray();
                    })
                    ->searchable()
                    ->required(),
                Forms\Components\TextInput::make('amount')
                    ->label('费用')
                    ->numeric()
                    ->inputMode('decimal')
                    ->minValue(0)
                    ->prefix($settings ? ($settings->currency->symbol ?: $settings->currency->code) : '')
                    ->required(),
                Forms\Components\Textarea::make('notes')
                    ->label('备注')
                    ->placeholder('简要说明来源、去向...')
                    ->maxLength(100),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('account.name')
                    ->label('账户'),
                Tables\Columns\TextColumn::make('type')
                    ->label('类别')
                    ->badge(),
                Tables\Columns\TextColumn::make('category.name')
                    ->label('类型')
                    ->description(fn(Transaction $transaction): string => $transaction->notes ?: ''),
                Tables\Columns\TextColumn::make('amount')
                    ->prefix(fn(Transaction $transaction): string => $transaction->currency->symbol ?: $transaction->code)
                    ->label('费用'),
                Tables\Columns\TextColumn::make('date')
                    ->label('日期')
                    ->date('Y-m-d'),
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
        return parent::getEloquentQuery()->where('user_id', auth()->id())->orderByDesc('id');
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
            'index' => Pages\ListTransactions::route('/'),
            'create' => Pages\CreateTransaction::route('/create'),
            'edit' => Pages\EditTransaction::route('/{record}/edit'),
        ];
    }
}
