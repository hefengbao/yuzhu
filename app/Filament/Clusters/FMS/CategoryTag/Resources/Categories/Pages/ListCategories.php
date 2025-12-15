<?php

namespace App\Filament\Clusters\FMS\CategoryTag\Resources\Categories\Pages;

use App\Filament\Clusters\FMS\CategoryTag\Resources\Categories\CategoryResource;
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
