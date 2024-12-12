<?php

namespace App\Filament\Clusters\Post\Comment\Resources\SpamResource\Pages;

use App\Filament\Clusters\Post\Comment\Resources\SpamResource;
use Filament\Resources\Pages\CreateRecord;

class CreateComment extends CreateRecord
{
    protected static string $resource = SpamResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['ip'] = request()->ip();
        $data['user_id'] = auth()->id();

        return $data;
    }
}
