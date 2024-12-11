<?php

namespace App\Filament\Pages\Widgets\Finance;

use App\Constant\Finance\FinanceType;
use App\Models\Finance\Transaction;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class IncomeExpenseMonthChart extends ChartWidget
{
    protected static ?string $heading = '收入/支出按月份统计';

    public function getDescription(): ?string
    {
        $startDate = $this->filters['startDate'] ?? Carbon::now()->firstOfYear()->format('Y-m-d');
        $endDate = $this->filters['endDate'] ?? Carbon::now()->format('Y-m-d');

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
        $startDate = $this->filters['startDate'] ?? Carbon::now()->firstOfYear()->format('Y-m-d');
        $endDate = $this->filters['endDate'] ?? Carbon::now()->format('Y-m-d');

        $dataIncome = Trend::query(
            Transaction::where('type', FinanceType::Income)
                ->where('user_id', auth()->id())
        )
            ->dateColumn('date')
            ->between(
                Carbon::createFromFormat('Y-m-d', $startDate),
                Carbon::createFromFormat('Y-m-d', $endDate)
            )
            ->perMonth()
            ->count();
        $dataExpenses = Trend::query(Transaction::where('type', FinanceType::Expense))
            ->dateColumn('date')
            ->between(
                Carbon::createFromFormat('Y-m-d', $startDate),
                Carbon::createFromFormat('Y-m-d', $endDate)
            )
            ->perMonth()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => '收入',
                    'data' => $dataIncome->map(fn(TrendValue $value) => $value->aggregate),
                    'borderColor' => '#5dae8b',
                ],
                [
                    'label' => '支出',
                    'data' => $dataExpenses->map(fn(TrendValue $value) => $value->aggregate),
                    'borderColor' => '#ff7676',
                ],
            ],
            'labels' => $dataIncome->map(fn(TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
