<?php

namespace App\Filament\Resources\FMS\AccountResource\Pages;

use App\Enums\FMS\AccountType;
use App\Filament\Resources\FMS\AccountResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditAccount extends EditRecord
{
    protected static string $resource = AccountResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (AccountType::parse($data['type']) != AccountType::Credit) {
            unset($data['credit_limit']);
            unset($data['settlement_day']);
        }

        return $data;
    }
}
