<?php

namespace App\Filament\Clusters\FMS\CategoryTag\Resources\SubCategories\Pages;

use App\Filament\Clusters\FMS\CategoryTag\Resources\SubCategories\SubCategoryResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSubCategory extends EditRecord
{
    protected static string $resource = SubCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
