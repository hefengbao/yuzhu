<?php

namespace App\Filament\Resources\FMS\TransactionResource\Pages;

use App\Filament\Resources\FMS\TransactionResource;
use App\Models\FMS\Category;
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

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $category = Category::where('id', $data['category_id'])->firstOrFail();
        $data['parent_id'] = $category->parent_id;
        return $data;
    }
}
