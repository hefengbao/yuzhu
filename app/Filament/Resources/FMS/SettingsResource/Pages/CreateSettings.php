<?php

namespace App\Filament\Resources\FMS\SettingsResource\Pages;

use App\Filament\Resources\FMS\SettingsResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;

class CreateSettings extends CreateRecord
{
    protected static string $resource = SettingsResource::class;
    protected static ?string $title = '财务设置';
    protected static ?string $breadcrumb = '财务设置';

    protected static bool $canCreateAnother = false;

    protected function getCancelFormAction(): Action
    {
        return Action::make('cancel')->hidden();
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        return [
            'user_id' => auth()->id(),
            'currency_id' => $data['currency']
        ];
    }
}
