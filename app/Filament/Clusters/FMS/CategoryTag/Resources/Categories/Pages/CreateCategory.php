<?php

namespace App\Filament\Clusters\FMS\CategoryTag\Resources\Categories\Pages;

use App\Filament\Clusters\FMS\CategoryTag\Resources\Categories\CategoryResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCategory extends CreateRecord
{
    protected static string $resource = CategoryResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
