<?php

namespace App\Filament\Clusters\FMS\CategoryTag\Resources\Tags\Pages;

use App\Filament\Clusters\FMS\CategoryTag\Resources\Tags\TagResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewTag extends ViewRecord
{
    protected static string $resource = TagResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
