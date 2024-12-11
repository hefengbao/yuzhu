<?php

namespace App\Filament\Clusters\Finance\Category\Resources\GroupResource\Pages;

use App\Filament\Clusters\Finance\Category\Resources\GroupResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGroups extends ListRecords
{
    protected static string $resource = GroupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
