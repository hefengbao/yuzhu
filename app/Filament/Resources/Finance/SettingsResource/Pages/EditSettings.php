<?php

namespace App\Filament\Resources\Finance\SettingsResource\Pages;

use App\Filament\Resources\Finance\SettingsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSettings extends EditRecord
{
    protected static string $resource = SettingsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
