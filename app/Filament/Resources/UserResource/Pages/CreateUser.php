<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Events\UserRegistered;
use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['password'] = \Hash::make($data['password']);

        return $data;
    }

    protected function afterCreate(): void
    {
        event(new UserRegistered($this->record));
    }

    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }
}
