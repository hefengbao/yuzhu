<?php

namespace App\Filament\Clusters\FMS\CategoryTag\Resources\SubCategories\Schemas;

use App\Enums\FMS\FinanceType;
use App\Models\FMS\Category;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;

class SubCategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('type')
                    ->label('类型')
                    ->options(FinanceType::class)
                    ->required()
                    ->columnSpanFull()
                    ->live()
                    ->afterStateUpdated(function (Set $set) {
                        $set('parent_id', null);
                    }),
                Select::make('parent_id')
                    ->label('父类')
                    ->options(fn(Get $get) => Category::query()->where('type', $get('type'))->whereNull('parent_id')->pluck('name', 'id'))
                    ->columnSpanFull(),
                TextInput::make('name')
                    ->label('名称')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }
}
