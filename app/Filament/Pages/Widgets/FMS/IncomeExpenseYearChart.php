<?php

namespace App\Filament\Pages\Widgets\FMS;

use App\Constant\FMS\FinanceType;
use App\Models\FMS\Transaction;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class IncomeExpenseYearChart extends ChartWidget
{
    protected ?string $heading = '收入/支出按年份统计';

    public function getDescription(): ?string
    {
        $startDate = $this->pageFilters['startDate'] ?? Carbon::now()->firstOfYear()->format('Y-m-d');
        $endDate = $this->pageFilters['endDate'] ?? Carbon::now()->format('Y-m-d');

        return $startDate . ' - ' . $endDate;
    }

    public function getColumnSpan(): int|string|array
    {
        return [
            'lg' => 2,
            'md' => 1,
        ];
    }

    protected function getData(): array
    {
        $startDate = $this->pageFilters['startDate'] ?? Carbon::now()->firstOfYear()->format('Y-m-d');
        $endDate = $this->pageFilters['endDate'] ?? Carbon::now()->format('Y-m-d');

        $dataIncome = Trend::query(
            Transaction::where('type', FinanceType::Income)
                ->where('user_id', auth()->id())
        )
            ->dateColumn('date')
            ->between(
                Carbon::createFromFormat('Y-m-d', $startDate),
                Carbon::createFromFormat('Y-m-d', $endDate)
            )
            ->perYear()
            ->sum('amount');
        $dataExpenses = Trend::query(Transaction::where('type', FinanceType::Expense))
            ->dateColumn('date')
            ->between(
                Carbon::createFromFormat('Y-m-d', $startDate),
                Carbon::createFromFormat('Y-m-d', $endDate)
            )
            ->perYear()
            ->sum('amount');

        return [
            'datasets' => [
                [
                    'label' => '收入',
                    'data' => $dataIncome->map(fn(TrendValue $value) => $value->aggregate),
                    'borderColor' => '#5dae8b',
                    'backgroundColor' => '#5dae8b',
                ],
                [
                    'label' => '支出',
                    'data' => $dataExpenses->map(fn(TrendValue $value) => $value->aggregate),
                    'borderColor' => '#ff7676',
                    'backgroundColor' => '#ff7676',
                ],
            ],
            'labels' => $dataIncome->map(fn(TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
