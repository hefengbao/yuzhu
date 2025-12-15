<?php

namespace App\Filament\Clusters\FMS\CategoryTag\Resources\Tags\Schemas;

use App\Enums\FMS\FinanceType;
use App\Models\FMS\Category;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class TagForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('type')
                    ->label('类型')
                    ->options(FinanceType::class)
                    ->live()
                    ->afterStateUpdated(function (Set $set) {
                        $set('parent_id', null);
                        $set('category_id', null);
                    })
                    ->columnSpanFull()
                    ->required(),
                /*Select::make('parent_id')
                    ->label('一级分类')
                    ->preload()
                    ->options(fn(Get $get): Collection => Category::query()->where('type', $get('type'))->whereNull('parent_id')->pluck('name', 'id'))
                    ->live()
                    ->afterStateUpdated(function (Set $set) {
                        $set('category_id', null);
                    })
                    ->required()
                    ->columnSpanFull(),*/
                Select::make('parent_id')
                    ->label('一级分类')
                    ->preload()
                    ->relationship('category.parent', 'name', fn(Get $get, Builder $query) => $query->whereNull('parent_id')->where('type', $get('type')))
                    //->options(fn(Get $get): Collection => Category::query()->where('type', $get('type'))->whereNull('parent_id')->pluck('name', 'id'))
                    ->live()
                    ->afterStateUpdated(function (Set $set) {
                        $set('category_id', null);
                    })
                    ->required()
                    ->columnSpanFull(),
                /*Select::make('category_id')
                    ->label('二级分类')
                    ->options(fn(Get $get): Collection => $get('parent_id') ? Category::query()->where('parent_id', $get('parent_id'))->pluck('name', 'id') : collect())
                    ->live()
                    ->required()
                    ->columnSpanFull(),*/
                Select::make('category_id')
                    ->label('二级分类')
                    ->preload()
                    ->relationship('category', 'name', fn(Get $get, Builder $query) => $query->whereNotNull('parent_id')->where('parent_id', $get('parent_id')))
                    //->options(fn(Get $get): Collection => $get('parent_id') ? Category::query()->where('parent_id', $get('parent_id'))->pluck('name', 'id') : collect())
                    ->live()
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('name')
                    ->label('名称')
                    ->columnSpanFull()
                    ->required(),
            ]);
    }
}
