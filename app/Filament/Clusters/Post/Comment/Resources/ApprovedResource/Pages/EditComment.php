<?php

namespace App\Filament\Clusters\Post\Comment\Resources\ApprovedResource\Pages;

use App\Filament\Clusters\Post\Comment\Resources\ApprovedResource;
use Filament\Resources\Pages\EditRecord;

class EditComment extends EditRecord
{
    protected static string $resource = ApprovedResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //Actions\DeleteAction::make(),
        ];
    }
}
