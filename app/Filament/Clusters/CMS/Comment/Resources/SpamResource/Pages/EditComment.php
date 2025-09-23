<?php

namespace App\Filament\Clusters\CMS\Comment\Resources\SpamResource\Pages;

use App\Filament\Clusters\CMS\Comment\Resources\SpamResource;
use Filament\Resources\Pages\EditRecord;

class EditComment extends EditRecord
{
    protected static string $resource = SpamResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //Actions\DeleteAction::make(),
        ];
    }
}
