<?php

namespace App\Filament\Resources\Settings\BlacklistResource\Pages;

use App\Filament\Resources\Settings\BlacklistResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListBlacklists extends ListRecords
{
    protected static string $resource = BlacklistResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
