<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;
use Hash;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->label('禁止账号')
                ->requiresConfirmation(),
            RestoreAction::make()
                ->label('恢复账号')
                ->color('success')
                ->requiresConfirmation(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if ($data['password']) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        return $data;
    }
}
