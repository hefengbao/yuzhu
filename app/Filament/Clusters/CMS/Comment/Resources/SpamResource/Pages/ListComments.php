<?php

namespace App\Filament\Clusters\CMS\Comment\Resources\SpamResource\Pages;

use App\Filament\Clusters\CMS\Comment\Resources\SpamResource;
use Filament\Resources\Pages\ListRecords;

class ListComments extends ListRecords
{
    protected static string $resource = SpamResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //Actions\CreateAction::make()
        ];
    }
}
