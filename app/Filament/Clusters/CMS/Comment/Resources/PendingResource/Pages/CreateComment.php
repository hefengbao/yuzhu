<?php

namespace App\Filament\Clusters\CMS\Comment\Resources\PendingResource\Pages;

use App\Filament\Clusters\CMS\Comment\Resources\PendingResource;
use Filament\Resources\Pages\CreateRecord;

class CreateComment extends CreateRecord
{
    protected static string $resource = PendingResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['ip'] = request()->ip();
        $data['user_id'] = auth()->id();

        return $data;
    }
}
