<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Constant\Role;
use App\Filament\Resources\UserResource;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        /** @var User $auth */
        $auth = auth()->user();

        return [
            Actions\CreateAction::make()->visible($auth->role === Role::Administrator),
        ];
    }
}
