<?php

namespace App\Filament\Resources\Post\CategoryResource\Pages;

use App\Filament\Resources\Post\CategoryResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCategory extends CreateRecord
{
    protected static string $resource = CategoryResource::class;
}
