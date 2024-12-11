<?php

namespace App\Filament\Pages;


use App\Filament\Pages\Widgets\Finance\ExpensePie;
use App\Filament\Pages\Widgets\Finance\IncomeExpenseMonthChart;
use App\Filament\Pages\Widgets\Finance\IncomeExpenseStats;
use App\Filament\Pages\Widgets\Finance\IncomeExpenseYearChart;
use App\Filament\Pages\Widgets\Finance\IncomePie;
use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;

class FinanceDashboard extends \Filament\Pages\Dashboard
{
    use HasFiltersForm;

    protected static string $routePath = 'finance';
    protected static ?string $title = '仪表板';
    protected static ?string $navigationGroup = '财务';
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationIcon = '';


    public function filtersForm(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        DatePicker::make('startDate')
                            ->label('开始日期')
                            ->format('Y-m-d')
                            ->default(Carbon::now()->firstOfYear()->format('Y-m-d')),
                        DatePicker::make('endDate')
                            ->label('结束日期')
                            ->format('Y-m-d')
                            ->default(Carbon::now()->format('Y-m-d')),
                    ])
                    ->columns(3),
            ]);
    }

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
            IncomeExpenseStats::class,
            IncomePie::class,
            ExpensePie::class,
            IncomeExpenseMonthChart::class,
            IncomeExpenseYearChart::class,
        ];
    }
}
