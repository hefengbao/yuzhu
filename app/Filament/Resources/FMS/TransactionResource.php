<?php

namespace App\Filament\Resources\FMS;

use App\Enums\FMS\FinanceType;
use App\Filament\Resources\FMS\TransactionResource\Pages\CreateTransaction;
use App\Filament\Resources\FMS\TransactionResource\Pages\EditTransaction;
use App\Filament\Resources\FMS\TransactionResource\Pages\ListTransactions;
use App\Filament\Resources\FMS\TransactionResource\RelationManagers;
use App\Models\FMS\Category;
use App\Models\FMS\Tag;
use App\Models\FMS\Transaction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $modelLabel = '记账';
    protected static ?string $pluralModelLabel = '记账';
    protected static string|\UnitEnum|null $navigationGroup = '财务';
    protected static ?int $navigationSort = 1;

    protected static ?string $slug = 'fms/transactions';

    public static function form(Schema $schema): Schema
    {
        $settings = auth()->user()->fmsSettings;

        return $schema
            ->components([
                Select::make('account_id')
                    ->label('账户')
                    ->relationship(
                        'account',
                        'name',
                        fn(Builder $query) => $query->where('user_id', auth()->id())
                            ->where('status', 1)
                    )
                    ->columnSpanFull()
                    ->required(),
                DatePicker::make('date')
                    ->label('日期')
                    ->format('Y-m-d')
                    ->displayFormat('Y-m-d')
                    ->default(date('Y-m-d'))
                    ->required()
                    ->columnSpanFull(),
                Select::make('type')
                    ->label('类型')
                    ->options(FinanceType::class)
                    ->required()
                    ->live()
                    ->afterStateUpdated(function (Set $set) {
                        $set('parent_id', null);
                        $set('category_id', null);
                        $set('tag_id', null);
                    })
                    ->columnSpanFull(),
                Select::make('parent_id')
                    ->label('一级分类')
                    ->options(function (Get $get) {
                        return Category::whereNull('parent_id')
                            ->where('type', $get('type'))
                            ->where('user_id', auth()->id())
                            ->get()
                            ->pluck('name', 'id')
                            ->toArray();
                    })
                    ->live()
                    ->afterStateUpdated(function (Set $set) {
                        $set('category_id', null);
                        $set('tag_id', null);
                    })
                    ->required()
                    ->searchable()
                    ->columnSpanFull(),
                Select::make('category_id')
                    ->label('二级分类')
                    ->options(function (Get $get) {
                        return Category::where('parent_id', $get('parent_id'))
                            ->get()
                            ->pluck('name', 'id')
                            ->toArray();
                    })
                    ->live()
                    ->afterStateUpdated(function (Set $set) {
                        $set('tag_id', null);
                    })
                    ->searchable()
                    ->required()
                    ->columnSpanFull(),
                Select::make('tag_id')
                    ->label('标签')
                    ->options(function (Get $get) {
                        return Tag::where('category_id', $get('category_id'))
                            ->get()
                            ->pluck('name', 'id')
                            ->toArray();
                    })
                    ->live()
                    ->searchable()
                    ->columnSpanFull(),
                TextInput::make('amount')
                    ->label('费用')
                    ->numeric()
                    ->inputMode('decimal')
                    ->minValue(0)
                    ->prefix($settings ? ($settings->currency->symbol ?: $settings->currency->code) : '')
                    ->required()
                    ->columnSpanFull(),
                Textarea::make('notes')
                    ->label('备注')
                    ->placeholder('简要说明来源、去向...')
                    ->maxLength(100)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('account.name')
                    ->label('账户'),
                TextColumn::make('type')
                    ->label('类别')
                    ->badge(),
                TextColumn::make('category.name')
                    ->label('类型')
                    ->description(fn(Transaction $transaction): string => $transaction->notes ?: ''),
                TextColumn::make('amount')
                    ->prefix(fn(Transaction $transaction): string => $transaction->currency->symbol ?: $transaction->code)
                    ->label('费用')
                    ->alignEnd(),
                TextColumn::make('date')
                    ->label('日期')
                    ->date('Y-m-d'),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //DeleteBulkAction::make(),
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
            'index' => ListTransactions::route('/'),
            'create' => CreateTransaction::route('/create'),
            'edit' => EditTransaction::route('/{record}/edit'),
        ];
    }
}
