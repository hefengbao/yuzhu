<?php

namespace App\Filament\Resources\Finance\AccountResource\Pages;

use App\Constant\Finance\AccountType;
use App\Filament\Resources\Finance\AccountResource;
use Filament\Resources\Pages\CreateRecord;

class CreateAccount extends CreateRecord
{
    protected static string $resource = AccountResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();

        if ($data['type'] != AccountType::Credit) {
            unset($data['credit_limit']);
            unset($data['settlement_day']);
        }

        return $data;
    }
}
