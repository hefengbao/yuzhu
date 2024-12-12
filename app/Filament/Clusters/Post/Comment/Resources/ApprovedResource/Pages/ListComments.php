<?php

namespace App\Filament\Clusters\Post\Comment\Resources\ApprovedResource\Pages;

use App\Filament\Clusters\Post\Comment\Resources\ApprovedResource;
use Filament\Resources\Pages\ListRecords;

class ListComments extends ListRecords
{
    protected static string $resource = ApprovedResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //Actions\CreateAction::make()
        ];
    }
}
