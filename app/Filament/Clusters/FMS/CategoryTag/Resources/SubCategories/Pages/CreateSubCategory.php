<?php

namespace App\Filament\Clusters\FMS\CategoryTag\Resources\SubCategories\Pages;

use App\Filament\Clusters\FMS\CategoryTag\Resources\SubCategories\SubCategoryResource;
use Filament\Resources\Pages\CreateRecord;

class CreateSubCategory extends CreateRecord
{
    protected static string $resource = SubCategoryResource::class;

    protected static bool $canCreateAnother = true;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
