<?php

namespace App\Filament\Pages\Widgets\Finance;

use App\Constant\Finance\FinanceType;
use App\Models\Finance\Transaction;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class ExpensePie extends ChartWidget
{
    protected static ?string $heading = '支出分类统计';

    protected static ?string $maxHeight = '400px';

    protected static ?array $options = [
        'scales' => [
            'x' => [
                'grid' => [
                    'display' => false,
                ],
                'ticks' => [
                    'display' => false,
                ]
            ],
            'y' => [
                'grid' => [
                    'display' => false,
                ],
                'ticks' => [
                    'display' => false,
                ]
            ]
        ]
    ];

    public function getDescription(): ?string
    {
        $startDate = $this->filters['startDate'] ?? Carbon::now()->firstOfYear()->format('Y-m-d');
        $endDate = $this->filters['endDate'] ?? Carbon::now()->format('Y-m-d');

        return $startDate . ' - ' . $endDate;
    }

    public function getColumnSpan(): int|string|array
    {
        return [
            'lg' => 1,
            'md' => 1,
        ];
    }

    protected function getData(): array
    {
        $startDate = $this->filters['startDate'] ?? Carbon::now()->firstOfYear()->format('Y-m-d');
        $endDate = $this->filters['endDate'] ?? Carbon::now()->format('Y-m-d');

        $data = Transaction::with('category')
            ->where('user_id', auth()->id())
            ->where('type', FinanceType::Expense)
            ->where('date', '>=', $startDate)
            ->where('date', '<=', $endDate)
            ->get();

        $data = $data->groupBy('category.name')->map(function ($items) {
            return $items->sum('amount');
        })->toArray();

        return [
            'datasets' => [
                [
                    'data' => array_values($data),
                    'backgroundColor' => [
                        'rgb(255, 99, 132)',
                        'rgb(54, 162, 235)',
                        'rgb(255, 205, 86)',
                        'rgb(192,192,192)',
                        'rgb(128,128,128)',
                        'rgb(128,0,0)',
                        'rgb(128,128,0)',
                        'rgb(0,128,0)',
                        'rgb(128,0,128)',
                        'rgb(0,128,128)',
                        'rgb(0,0,128)',
                        'rgb(255,99,71)',
                        'rgb(255,165,0)',
                        'rgb(154,205,50)',
                        'rgb(32,178,170)',
                        'rgb(47,79,79)',
                    ],
                    'hoverOffset' => 4,
                ],
            ],
            'labels' => array_keys($data),
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
