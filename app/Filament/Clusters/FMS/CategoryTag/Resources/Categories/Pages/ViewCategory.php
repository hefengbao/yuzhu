<?php

namespace App\Filament\Clusters\FMS\CategoryTag\Resources\Categories\Pages;

use App\Filament\Clusters\FMS\CategoryTag\Resources\Categories\CategoryResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewCategory extends ViewRecord
{
    protected static string $resource = CategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
