<?php

namespace App\Filament\Clusters\FMS\CategoryTag\Resources\SubCategories\Pages;

use App\Filament\Clusters\FMS\CategoryTag\Resources\SubCategories\SubCategoryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSubCategories extends ListRecords
{
    protected static string $resource = SubCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
