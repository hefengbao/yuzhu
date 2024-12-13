<?php

namespace App\Filament\Resources\Finance\AccountResource\Pages;

use App\Constant\Finance\AccountType;
use App\Filament\Resources\Finance\AccountResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAccount extends EditRecord
{
    protected static string $resource = AccountResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
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
