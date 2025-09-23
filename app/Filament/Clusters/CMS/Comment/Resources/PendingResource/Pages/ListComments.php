<?php

namespace App\Filament\Clusters\CMS\Comment\Resources\PendingResource\Pages;

use App\Filament\Clusters\CMS\Comment\Resources\PendingResource;
use Filament\Resources\Pages\ListRecords;

class ListComments extends ListRecords
{
    protected static string $resource = PendingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //Actions\CreateAction::make()
        ];
    }
}
