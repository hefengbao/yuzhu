<?php

namespace App\Filament\Resources\FMS;

use App\Filament\Resources\FMS\SettingsResource\Pages\CreateSettings;
use App\Filament\Resources\FMS\SettingsResource\RelationManagers;
use App\Models\FMS\Settings;
use App\Models\User;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class SettingsResource extends Resource
{
    protected static ?string $model = Settings::class;
    protected static ?string $modelLabel = '设置';
    protected static ?string $pluralModelLabel = '设置';
    protected static string|\UnitEnum|null $navigationGroup = '财务';
    protected static ?int $navigationSort = 5;

    protected static ?string $slug = 'fms/settings';

    public static function form(Schema $schema): Schema
    {
        /** @var User $user */
        $user = auth()->user();

        return $schema
            ->components([
                Select::make('currency')
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
            'index' => CreateSettings::route('/create'),
        ];
    }
}
