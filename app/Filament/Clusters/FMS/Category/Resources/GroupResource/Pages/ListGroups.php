<?php

namespace App\Filament\Clusters\FMS\Category\Resources\GroupResource\Pages;

use App\Filament\Clusters\FMS\Category\Resources\GroupResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListGroups extends ListRecords
{
    protected static string $resource = GroupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
