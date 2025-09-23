<?php

namespace App\Filament\Clusters\FMS\Category\Resources\GroupResource\Pages;

use App\Filament\Clusters\FMS\Category\Resources\GroupResource;
use Filament\Resources\Pages\CreateRecord;

class CreateGroup extends CreateRecord
{
    protected static string $resource = GroupResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();

        return $data;
    }
}
