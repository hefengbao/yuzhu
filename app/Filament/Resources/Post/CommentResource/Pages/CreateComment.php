<?php

namespace App\Filament\Resources\Post\CommentResource\Pages;

use App\Filament\Resources\Post\CommentResource;
use Filament\Resources\Pages\CreateRecord;

class CreateComment extends CreateRecord
{
    protected static string $resource = CommentResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {

        $data['ip'] = request()->ip();

        if (auth()) {
            $data['user_id'] = auth()->id();
            $data['guest_name'] = null;
            $data['guest_email'] = null;
        }

        return $data;
    }
}
