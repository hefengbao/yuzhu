<?php

namespace App\Filament\Clusters\Finance\Category\Resources\CategoryResource\Pages;

use App\Filament\Clusters\Finance\Category\Resources\CategoryResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCategory extends EditRecord
{
    protected static string $resource = CategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
