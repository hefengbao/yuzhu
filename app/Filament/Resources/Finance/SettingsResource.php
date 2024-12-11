<?php

namespace App\Filament\Resources\Finance;

use App\Filament\Resources\Finance\SettingsResource\Pages;
use App\Filament\Resources\Finance\SettingsResource\RelationManagers;
use App\Models\Finance\Settings;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class SettingsResource extends Resource
{
    protected static ?string $model = Settings::class;
    protected static ?string $modelLabel = '设置';
    protected static ?string $pluralModelLabel = '设置';

    protected static ?string $navigationGroup = '财务';
    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        /** @var User $user */
        $user = auth()->user();

        return $form
            ->schema([
                Forms\Components\Select::make('currency')
                    ->label('货币')
                    ->default($user->financeSettings->currency_id ?? '')
                    ->relationship('currency', 'name')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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
            'index' => Pages\CreateSettings::route('/create'),
        ];
    }
}
