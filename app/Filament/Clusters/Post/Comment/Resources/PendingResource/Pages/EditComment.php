<?php

namespace App\Filament\Clusters\Post\Comment\Resources\PendingResource\Pages;

use App\Filament\Clusters\Post\Comment\Resources\PendingResource;
use Filament\Resources\Pages\EditRecord;

class EditComment extends EditRecord
{
    protected static string $resource = PendingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //Actions\DeleteAction::make(),
        ];
    }
}
