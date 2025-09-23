<?php

namespace App\Filament\Resources\FMS\AccountResource\Pages;

use App\Constant\FMS\AccountType;
use App\Filament\Resources\FMS\AccountResource;
use Filament\Resources\Pages\CreateRecord;

class CreateAccount extends CreateRecord
{
    protected static string $resource = AccountResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();

        if (AccountType::parse($data['type']) != AccountType::Credit) {
            unset($data['credit_limit']);
            unset($data['settlement_day']);
        }

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
