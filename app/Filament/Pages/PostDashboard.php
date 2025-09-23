<?php

namespace App\Filament\Pages;


use App\Filament\Pages\Widgets\CMS\StatsOverview;
use Filament\Pages\Dashboard;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;

class PostDashboard extends Dashboard
{
    use HasFiltersForm;

    protected static string $routePath = 'cms';
    protected static ?string $title = '仪表板';
    protected static string|\UnitEnum|null $navigationGroup = '内容';
    protected static ?int $navigationSort = 1;
    protected static string|\BackedEnum|null $navigationIcon = '';

    public function getColumns(): int|array
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
