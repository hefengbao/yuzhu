<?php

namespace App\Filament\Clusters\FMS\CategoryTag\Resources\Tags\Pages;

use App\Filament\Clusters\FMS\CategoryTag\Resources\Tags\TagResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTags extends ListRecords
{
    protected static string $resource = TagResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
