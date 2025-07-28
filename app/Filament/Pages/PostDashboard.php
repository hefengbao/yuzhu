<?php

namespace App\Filament\Pages;


use App\Filament\Pages\Widgets\Post\StatsOverview;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;

class PostDashboard extends \Filament\Pages\Dashboard
{
    use HasFiltersForm;

    protected static string $routePath = 'cms';
    protected static ?string $title = '仪表板';
    protected static ?string $navigationGroup = '内容';
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationIcon = '';

    public function getColumns(): int|string|array
    {
        return [
            'lg' => 2,
            'md' => 1,
        ];
    }

    public function getWidgets(): array
    {
        return [
            StatsOverview::class,
        ];
    }
}
