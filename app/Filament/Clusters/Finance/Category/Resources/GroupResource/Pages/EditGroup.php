<?php

namespace App\Filament\Clusters\Finance\Category\Resources\GroupResource\Pages;

use App\Filament\Clusters\Finance\Category\Resources\GroupResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditGroup extends EditRecord
{
    protected static string $resource = GroupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
