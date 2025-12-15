<?php

namespace App\Filament\Clusters\FMS\CategoryTag\Resources\Tags\Pages;

use App\Filament\Clusters\FMS\CategoryTag\Resources\Tags\TagResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTag extends CreateRecord
{
    protected static string $resource = TagResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
