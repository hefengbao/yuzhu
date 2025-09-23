<?php

namespace App\Filament\Clusters\FMS\Category\Resources\CategoryResource\Pages;

use App\Filament\Clusters\FMS\Category\Resources\CategoryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCategories extends ListRecords
{
    protected static string $resource = CategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
