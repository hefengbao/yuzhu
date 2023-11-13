<?php

namespace App\Filament\Resources\Post\CommentResource\Pages;

use App\Filament\Resources\Post\CommentResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateComment extends CreateRecord
{
    protected static string $resource = CommentResource::class;
}
