<?php

namespace App\Filament\Resources\Finance\SettingsResource\Pages;

use App\Filament\Resources\Finance\SettingsResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSettings extends ListRecords
{
    protected static string $resource = SettingsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
