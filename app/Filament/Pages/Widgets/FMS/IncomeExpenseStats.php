<?php

namespace App\Filament\Pages\Widgets\FMS;

use App\Enums\FMS\FinanceType;
use App\Models\FMS\Transaction;
use Carbon\Carbon;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class IncomeExpenseStats extends StatsOverviewWidget
{
    use InteractsWithPageFilters;

    protected function getStats(): array
    {
        $startDate = $this->pageFilters['startDate'] ?? Carbon::now()->firstOfYear()->format('Y-m-d');
        $endDate = $this->pageFilters['endDate'] ?? Carbon::now()->format('Y-m-d');
        $endDate = Carbon::createFromFormat('Y-m-d', $endDate)->addDay()->format('Y-m-d');

        $settings = auth()->user()->fmsSettings;

        $symbol = $settings ? $settings->currency->symbol ?: $settings->currency->code : '￥';

        return [
            Stat::make(
                '收入',
                $symbol . number_format(
                    Transaction::where('type', FinanceType::Income)
                        ->where('user_id', auth()->id())
                        ->whereBetween('date', [$startDate, $endDate])
                        ->sum('amount'),
                    2
                )
            )
                ->color('success'),
            Stat::make(
                '支出',
                $symbol . number_format(
                    Transaction::where('type', FinanceType::Expense)
                        ->where('user_id', auth()->id())
                        ->whereBetween('date', [$startDate, $endDate])
                        ->sum('amount'),
                    2
                )
            )
                ->color('danger'),
        ];
    }
}
