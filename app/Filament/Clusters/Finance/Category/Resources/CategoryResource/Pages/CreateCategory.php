<?php

namespace App\Filament\Clusters\Finance\Category\Resources\CategoryResource\Pages;

use App\Filament\Clusters\Finance\Category\Resources\CategoryResource;
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
