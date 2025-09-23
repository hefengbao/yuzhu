<?php

namespace App\Filament\Clusters\FMS\Category\Resources\CategoryResource\Pages;

use App\Filament\Clusters\FMS\Category\Resources\CategoryResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCategory extends CreateRecord
{
    protected static string $resource = CategoryResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();

        return $data;
    }
}
