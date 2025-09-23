<?php

namespace App\Filament\Resources\Finance\TransactionResource\Pages;

use App\Filament\Resources\Finance\TransactionResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTransaction extends EditRecord
{
    protected static string $resource = TransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
