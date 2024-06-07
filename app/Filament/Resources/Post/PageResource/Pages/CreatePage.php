<?php

namespace App\Filament\Resources\Post\PageResource\Pages;

use App\Constant\PostStatus;
use App\Constant\PostType;
use App\Filament\Resources\Post\PageResource;
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
        $data['excerpt'] = Str::limit(str_replace(PHP_EOL, '', strip_tags(md_to_html($data['body']))), 160);
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
