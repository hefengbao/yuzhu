<?php

namespace App\Filament\Resources\Settings\BlacklistResource\Pages;

use App\Filament\Resources\Settings\BlacklistResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditBlacklist extends EditRecord
{
    protected static string $resource = BlacklistResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
