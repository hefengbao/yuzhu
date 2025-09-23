<?php

namespace App\Filament\Resources\Settings\SiteResource\Pages;

use App\Filament\Resources\Settings\SiteResource;
use App\Models\Settings\Option;
use Cache;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateSite extends CreateRecord
{
    protected static string $resource = SiteResource::class;

    protected static ?string $title = '站点设置';

    protected static ?string $breadcrumb = '站点设置';

    protected static bool $canCreateAnother = false;

    protected function getCancelFormAction(): Action
    {
        return Action::make('cancel')->hidden();
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $arr = [];

        foreach ($data as $key => $value) {
            $arr[] = [
                'name' => $key,
                'value' => $value,
            ];
        }

        return $arr;
    }

    protected function handleRecordCreation(array $data): Model
    {
        foreach ($data as $item) {
            Option::updateOrCreate(
                ['name' => $item['name']],
                [
                    'value' => $item['value'],
                    'autoload' => 'yes',
                ]
            );
        }

        Cache::forget('autoload_options');

        return new Option();
    }

    protected function getCreatedNotificationMessage(): ?string
    {
        return '保存成功';
    }
}
