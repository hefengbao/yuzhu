<?php

namespace App\Filament\Clusters\FMS\CategoryTag\Resources\Categories\Schemas;

use App\Enums\FMS\FinanceType;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
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
}
