<?php

namespace App\Filament\Clusters\Post\Comment\Resources\ApprovedResource\Pages;

use App\Filament\Clusters\Post\Comment\Resources\ApprovedResource;
use Filament\Resources\Pages\CreateRecord;

class CreateComment extends CreateRecord
{
    protected static string $resource = ApprovedResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['ip'] = request()->ip();
        $data['user_id'] = auth()->id();

        return $data;
    }
}
