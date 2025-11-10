<?php

namespace App\Filament\Resources\CMS\PageResource\Pages;

use App\Enums\CMS\PostStatus;
use App\Enums\CMS\PostType;
use App\Filament\Resources\CMS\PageResource;
use Carbon\Carbon;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;

class CreatePage extends CreateRecord
{
    protected static string $resource = PageResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();
        $data['ip'] = request()->ip();
        $data['excerpt'] = Str::limit(str_replace(PHP_EOL, '', strip_tags(Str::markdown($data['body']))), 160);
        $data['type'] = PostType::Page->value;
        $data['status'] = PostStatus::Published->value;
        $data['published_at'] = Carbon::now();

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
